<?php

/**
 * Set google client
 *
 * @param string $endpoint make call to this enpoint
 * @param array $params array keys are the variable names required by the endpoint
 *
 * @return array $response
 */
function setGoogleClient()
{
	// open curl call, set endpoint and other curl params

	$client = new Google_Client();
	$client->setClientId(GOOGLE_CLIENT_ID);
	$client->setClientSecret(GOOGLE_CLIENT_SECRET);
	$client->setRedirectUri(GOOGLE_REDIRECT_URI);
	$client->addScope('profile');
	$client->addScope('email');

	return $client;
}

/**
 * Get Google api login url that will take the user to google and present them with login dialog
 *
 * Endpoint: 
 *
 * @param void
 *
 * @return string
 */
function getGoogleLoginUrl()
{
	$client = setGoogleClient();

	// endpoint for Google login dialog
	return $client->createAuthUrl();
}

function tryAndLoginWithGoogle($get, $usersController)
{
	$userModel = $usersController->userModel;

	// assume fail
	$status = 'fail';
	$message = '';

	// reset session vars
	$_SESSION['google_access_token'] = array();
	$_SESSION['google_user_info'] = array();
	$_SESSION['eci_login_required_to_connect_google'] = false;

	if (isset($get['error'])) {
		// error comming from facebook GET vars
		$message = $get['error_description'];
		redirect('users/login');
	} else {
		// no error in facebook GET vars
		// get an access token with the code facebook sent us
		$client = setGoogleClient();
		$accessTokenInfo = $client->fetchAccessTokenWithAuthCode($get['code']);

		if (isset($accessTokenInfo['error'])) {
			// there was an error getting an access token with the code
			$message = $accessTokenInfo['error'];
			die($message);
		} else {
			// we have access token! :D
			$_SESSION['google_access_token'] = $accessTokenInfo['access_token'];

			$client->setAccessToken($accessTokenInfo);
			$gauth = new Google_Service_Oauth2($client);
			$googleUserInfo = $gauth->userinfo->get();

			if (!empty($googleUserInfo['id']) && !empty($googleUserInfo['email'])) { // google gave us the users id/email
				// 	all good!
				$status = 'ok';

				// save user info to session
				$_SESSION['google_user_info'] = $googleUserInfo;

				// check for user with facebook id		
				$userInfoWithId = $userModel->getRowWithValue('users', 'google_user_id', $googleUserInfo->id);

				// check for user with email
				$userInfoWithEmail = $userModel->getRowWithValue('users', 'email', $googleUserInfo->email);
				if ($userInfoWithId || ($userInfoWithEmail && !$userInfoWithEmail->password)) { // user has logged in with facebook before so we found them
					// update user
					$userModel->updateRowById('users', 'google_access_token', $_SESSION['google_access_token'], $userInfoWithEmail->id);

					if (empty($userInfoWithEmail->google_user_id)) {
						$userModel->updateRowById('users', 'google_user_id', $googleUserInfo['id'], $userInfoWithEmail->id);
					}

					if ($userInfoWithEmail) {
						$usersController->createUserSession($userInfoWithEmail, false);
					}
				} elseif ($userInfoWithEmail && !$userInfoWithEmail->google_user_id) {
					/*
						existing account exists for the email and has not logged in 
						with Google before
						*/
					$_SESSION['eci_login_required_to_connect_google'] = true;
				} else {
					// sign up and sign in users if not found with id/email 				
					$client->setAccessToken($_SESSION['google_access_token']);

					$userModel->register(
						[
							'email' => $googleUserInfo->email,
							'first_name' => $googleUserInfo->givenName,
							'last_name' => $googleUserInfo->familyName,
							'google_user_id' => $googleUserInfo->id,
							'google_access_token' => $accessTokenInfo['access_token']
						]
					);
					$userInfo = $userModel->getRowWithValue('users', 'google_user_id', $googleUserInfo['id']);

					if ($userInfo) {
						$usersController->createUserSession($userInfo, false);
					}
				}
			} else {
				$message = 'Sorry but we require your email in this system.';
				redirect('users/login');
			}
		}
	}

	return array( // return status and message of login
		'status' => $status,
		'message' => $message,
	);
}

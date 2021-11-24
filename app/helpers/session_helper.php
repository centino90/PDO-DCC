<?php
session_start();

// Flash message helper
// EXAMPLE - flash('register_success', 'You are now registered');
// DISPLAY IN VIEW - echo flash('register_success');
function flash($name = '', $label = '', $message = '', $class = 'bg-green-600')
{
  if (!empty($name)) {
    if (!empty($label) && empty($_SESSION[$name])) {
      if (!empty($_SESSION[$name])) {
        unset($_SESSION[$name]);
      }

      if (!empty($_SESSION[$name . '_message'])) {
        unset($_SESSION[$name . '_message']);
      }

      $_SESSION[$name] = $label;
      $_SESSION[$name . '_message'] = $message;
      $_SESSION[$name . '_class'] = $class;
    } elseif (empty($label) && !empty($_SESSION[$name])) {
      echo '<div class="flex max-w-sm w-full bg-white shadow-md rounded-lg overflow-hidden mx-auto my-5">' .
        '<div class="w-2 ' .$_SESSION[$name . '_class'] . '">' .
        '</div>' .
        '<div class="w-full flex justify-between px-2 py-2">' .
        '<div class="flex flex-col ml-2">' .
        '<label class="text-gray-800 text-left">' . $_SESSION[$name] . '</label>' .
        '<small class="text-gray-500 text-left">' . $_SESSION[$name . "_message"] . '</small>' .
        '</div>' .
        '<a href="#">' .
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">' .
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' .
        '</svg>' .
        '</a>' .
        '</div>' .
        '</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}

function isLoggedIn()
{
  if (isset($_SESSION['user_id'])) {
    return true;
  } else {
    return false;
  }
}

function isCompleteInfo()
{
  if (isset($_SESSION['complete_info']) && $_SESSION['complete_info'] == true) {
    return true;
  } else {
    return false;
  }
}

// function currentInfoNumber()
// {
//   if (isset($_SESSION['current_info_number']) && $_SESSION['current_info_number'] == true) {
//     return true;
//   } else {
//     return false;
//   }
// }

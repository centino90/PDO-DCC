<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        Sign in with your account
      </h2>
    </div>
    <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/login" method="post">
      <!-- <div class="text-black text-center">
        <?php flash('register_success'); ?>
      </div> -->

      <div class="flex flex-col gap-y-5">
        <div class="relative rounded-md">
          <input type="email" name="email" id="email" class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-secondary-300 rounded-md" placeholder="Email address">
          <?php if (!empty($data['email_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['email_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <div class="relative rounded-md">
          <input type="password" name="password" id="password" class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-secondary-300 rounded-md" placeholder="Password">
          <?php if (!empty($data['password_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['password_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <div class="flex items-center justify-end">
          <div class="text-sm">
            <a href="<?php echo URLROOT; ?>/users/register" class="font-medium text-primary-600 hover:text-primary-500">
              Not registered yet? Create an account
            </a>
          </div>
        </div>

        <!-- Form submit -->
        <div class="mt-4">
          <button type="submit" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
            Sign in
          </button>
        </div>
      </div>
    </form>

    <div class="flex justify-evenly space-x-2 mt-4">
      <span class="bg-secondary-300 h-px flex-grow t-2 relative top-2"></span>
      <span class="flex-none uppercase text-xs text-secondary-500 font-semibold">Or continue with</span>
      <span class="bg-secondary-300 h-px flex-grow t-2 relative top-2"></span>
    </div>

    <div>
      <div>
        <a href="<?php echo getFacebookLoginUrl(); ?>" class="block text-center w-full bg-blue-700 hover:bg-blue-900 rounded-md text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Facebook
        </a>
      </div>

      <div>
        <a href="<?php echo getGoogleLoginUrl(); ?>" class="mt-2 block text-center w-full bg-danger-700 hover:bg-danger-800 rounded-md text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Google
        </a>
      </div>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
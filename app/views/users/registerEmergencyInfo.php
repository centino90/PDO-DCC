<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
  <div class="mb-8">
    <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
      Register additional information
    </h2>
  </div>
  <div class="w-full py-6">
    <!-- Steps -->
    <div class="flex max-w-3xl w-full mx-auto mb-12">
      <div class="step">
        <div class="step-separator">
          <div class="step-icon done">
            <span class="step-icon-content current">
              <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label">License information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg full"></div>
            </div>
          </div>

          <div class="step-icon done">
            <span class="step-icon-content current">
              <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M19 10h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2h-2a1 1 0 0 1 0-2h2V8a1 1 0 0 1 2 0v2zM9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm8 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h5a5 5 0 0 1 5 5v2z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label">Personal information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg full"></div>
            </div>
          </div>

          <div class="step-icon done">
            <span class="step-icon-content current">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label done">Clinic information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg full"></div>
            </div>
          </div>

          <div class="step-icon current">
            <span class="step-icon-content current">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label current">Case of emergency</div>
      </div>
    </div>

    <!-- Case of emergency information -->
    <div class="max-w-3xl w-full mx-auto">
      <form action="<?php echo URLROOT; ?>/users/registerEmergencyInfo" method="post">
        <header class="flex items-center gap-3 py-5 mb-5 text-xl text-primary-500">
          <span class="font-bold mr-2">Step 4:</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
          </svg>

          In case of emergency
        </header>

        <div class="flex flex-col gap-y-5">
          <!-- Full name -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Full name <span class="text-danger-500">*</span>
            </label>
            <input type="text" value="<?php echo $data['emergency_person_name'] ?>" x-bind="formInput" name="emergency_person_name">
            <?php if (!empty($data['emergency_person_name_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['emergency_person_name_err']; ?> !
              </div>
            <?php endif; ?>
          </div>

          <!-- Address -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Address <span class="text-danger-500">*</span>
            </label>
            <input type="text" value="<?php echo $data['emergency_address'] ?>" x-bind="formInput" name="emergency_address">
            <?php if (!empty($data['emergency_address_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['emergency_address_err']; ?> !
              </div>
            <?php endif; ?>
          </div>

          <!-- Contact number -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Contact number <span class="text-danger-500">*</span>
            </label>
            <input type="number" value="<?php echo $data['emergency_contact_number'] ?>" x-bind="formInput" name="emergency_contact_number">
            <?php if (!empty($data['emergency_contact_number_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['emergency_contact_number_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="my-10 flex flex-col sm:flex-row gap-3">
          <a href="<?php echo URLROOT . '/users/registerClinicInfo' ?>" class="form-btn bg-secondary-500 text-white w-full md:w-80 py-2 px-4">
            Go back
          </a>
          <button type="submit" class="form-btn bg-primary-500 text-white w-full md:w-80 py-2 px-4">
            Submit to proceed
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('input', () => ({
      class: 'form-group',
      formLabel: {
        [':for']() {
          return this.$el.parentNode.querySelector('input, select, textarea').getAttribute('name')
        },
        [':class']() {
          return 'mb-4 form-label'
        }
      },
      formInput: {
        [':id']() {
          return this.$el.getAttribute('name')
        },
        [':class']() {
          return 'form-input'
        }
      },
      formInputError: {
        [':class']() {
          return 'form-input-err'
        }
      }
    }))
  })
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
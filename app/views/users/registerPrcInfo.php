<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
  <div class="mb-8">
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
      Register additional information
    </h2>
  </div>
  <div class="w-full py-6">
    <!-- Steps -->
    <div class="flex max-w-3xl w-full mx-auto mb-12">
      <div class="step">
        <div class="step-separator">
          <div class="step-icon current">
            <span class="step-icon-content current">
              <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label current">License information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg"></div>
            </div>
          </div>

          <div class="step-icon">
            <span class="step-icon-content">
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
              <div class="step-separator-bg"></div>
            </div>
          </div>

          <div class="step-icon">
            <span class="step-icon-content">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label">Clinic information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg"></div>
            </div>
          </div>

          <div class="step-icon">
            <span class="step-icon-content">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label">Case of emergency</div>
      </div>
    </div>

    <!-- License information -->
    <div class="max-w-3xl w-full mx-auto">
      <form action="<?php echo URLROOT; ?>/users/registerPrcInfo" method="post">
        <!-- <div class="text-black text-center mt-5 mb-8">
          <?php flash('login_status'); ?>
        </div> -->
        <header class="flex items-center gap-3 py-5 mb-5 text-xl text-primary-500">
          <span class="font-bold mr-2">Step 1:</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
          </svg>
          License information
        </header>

        <div class="flex flex-col gap-y-5">
          <!-- License no -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              PRC license no <span class="text-danger-500">*</span>
            </label>
            <input type="number" value="<?php echo $data['prc_number'] ?>" x-bind="formInput" name="prc_number">
            <?php if (!empty($data['prc_number_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['prc_number_err']; ?> !
              </div>
            <?php endif; ?>
          </div>

          <!-- Registration date -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Registration date <span class="text-danger-500">*</span>
            </label>
            <input type="date" value="<?php echo $data['prc_registration_date'] ?>" x-bind="formInput" name="prc_registration_date">
            <?php if (!empty($data['prc_registration_date_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['prc_registration_date_err']; ?> !
              </div>
            <?php endif; ?>
          </div>

          <!-- Expiration date -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Expiration date <span class="text-danger-500">*</span>
            </label>
            <input type="date" value="<?php echo $data['prc_expiration_date'] ?>" x-bind="formInput" name="prc_expiration_date">
            <?php if (!empty($data['prc_expiration_date_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['prc_expiration_date_err']; ?> !
              </div>
            <?php endif; ?>
          </div>

          <!-- Field of practice -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Field of practice <span class="text-danger-500">*</span>
              <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="!specified">Specify</a>
              <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="specified">Select</a>
            </label>
            <input type="text" value="<?php echo $data['field_practice'] ?>" x-bind="formInput" x-show="specified" :disabled="!specified" name="field_practice" placeholder="Specify your field of practice">
            <select x-bind="formInput" x-show="!specified" :disabled="specified" name="field_practice">
              <option value="">Select</option>
              <option <?php if ($data['field_practice'] == 'General Practice') : ?> selected <?php endif; ?> value="General Practice">General Practice</option>
              <option <?php if ($data['field_practice'] == 'Endodontics') : ?> selected <?php endif; ?> value="Endodontics">Endodontics</option>
              <option <?php if ($data['field_practice'] == 'Prosthodontics') : ?> selected <?php endif; ?> value="Prosthodontics">Prosthodontics</option>
              <option <?php if ($data['field_practice'] == 'Orthodontics') : ?> selected <?php endif; ?> value="Orthodontics">Orthodontics</option>
              <option <?php if ($data['field_practice'] == 'Oral and maxillofacial surgery') : ?> selected <?php endif; ?> value="Oral and maxillofacial surgery">Oral and maxillofacial surgery</option>
              <option <?php if ($data['field_practice'] == 'Pedodontics') : ?> selected <?php endif; ?> value="Pedodontics">Pedodontics</option>
              <option <?php if ($data['field_practice'] == 'Periodontics') : ?> selected <?php endif; ?> value="Periodontics">Periodontics</option>
            </select>
            <?php if (!empty($data['field_practice_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['field_practice_err']; ?> !
              </div>
            <?php endif; ?>
          </div>

          <!-- Type of practice -->
          <div x-data="input()" :class="class">
            <label x-bind="formLabel">
              Type of practice <span class="text-danger-500">*</span>
              <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="!specified">Specify</a>
              <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="specified">Select</a>
            </label>
            <input type="text" value="<?php echo $data['type_practice'] ?>" x-bind="formInput" x-show="specified" :disabled="!specified" name="type_practice" placeholder="Specify your type of practice">
            <select x-bind="formInput" x-show="!specified" :disabled="specified" name="type_practice">
              <option value="">Select</option>
              <option <?php if ($data['type_practice'] == 'Government Dentist') : ?> selected <?php endif; ?> value="Government Dentist">Government Dentist</option>
              <option <?php if ($data['type_practice'] == 'Clinic Owner') : ?> selected <?php endif; ?> value="Clinic Owner">Clinic Owner</option>
              <option <?php if ($data['type_practice'] == 'Dental Associate') : ?> selected <?php endif; ?> value="Dental Associate">Dental Associate</option>
              <option <?php if ($data['type_practice'] == 'School Dentist') : ?> selected <?php endif; ?> value="School Dentist">School Dentist</option>
              <option <?php if ($data['type_practice'] == 'None Practicing') : ?> selected <?php endif; ?> value="None Practicing">None Practicing</option>
            </select>
            <?php if (!empty($data['type_practice_err'])) : ?>
              <div x-bind="formInputError">
                <?php echo $data['type_practice_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Form submit -->
        <div class="my-10">        
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
      specified: false,
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
<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-1">
    <form action="<?php echo URLROOT; ?>/pages/clinicInfo" method="POST">
      <!-- <div class="text-black text-center">
        <?php flash('update_success'); ?>
      </div> -->

      <header class="flex items-center justify-between gap-3 mb-10">
        <div class="w-64 flex-shrink-0">
          <span class="text-lg font-medium">Clinic information</span>
        </div>
        <div>
          <a class="flex text-blue-400 hover:underline cursor-pointer" @click="onEditMode = !onEditMode" x-show="!onEditMode">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Enable editing
          </a>
          <a class="flex text-blue-400 hover:underline cursor-pointer" @click="onEditMode = !onEditMode" x-show="onEditMode">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Disable editing
          </a>
        </div>
      </header>

      <div class="flex flex-col gap-y-5">
        <!-- Name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Name
          </label>
          <input type="text" value="<?php echo $data['clinic_name'] ?>" x-bind="formGroup.formInput" name="clinic_name">
          <?php if (!empty($data['clinic_name_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['clinic_name_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Street -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Street
          </label>
          <input type="text" value="<?php echo $data['clinic_street'] ?>" x-bind="formGroup.formInput" name="clinic_street">
          <?php if (!empty($data['clinic_street_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['clinic_street_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- District -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            District
          </label>
          <input type="text" value="<?php echo $data['clinic_district'] ?>" x-bind="formGroup.formInput" name="clinic_district">
          <?php if (!empty($data['clinic_district_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['clinic_district_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- City -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            City
          </label>
          <input type="text" value="<?php echo $data['clinic_city'] ?>" x-bind="formGroup.formInput" name="clinic_city">
          <?php if (!empty($data['clinic_city_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['clinic_city_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Contact number -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Contact number
          </label>
          <input type="number" value="<?php echo $data['clinic_contact_number'] ?>" x-bind="formGroup.formInput" name="clinic_contact_number">
          <?php if (!empty($data['clinic_contact_number_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['clinic_contact_number_err']; ?> !
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Form submit -->
      <div class="my-10" x-show="onEditMode">
        <button type="submit" class="form-btn bg-primary-500 text-white w-full md:w-80 py-2 px-4">
          Submit to proceed
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        if (this.checkServerValidationError()) {
          this.onEditMode = true
        } else {
          this.onEditMode = false
        }
      },
      onEditMode: false,
      serverData: <?php echo json_encode($data); ?>,
      formGroup: {
        [':class']() {
          let defaultClass = 'form-group'

          return this.onEditMode ? `${defaultClass} border-0` : `${defaultClass} border-b`
        },
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
          [':disabled']() {
            return !this.onEditMode
          },
          [':class']() {
            let defaultClass = 'form-input'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-secondary-300`
          },
        },
        formInputError: {
          [':class']() {
            return 'form-input-err'
          }
        },
      },

      checkServerValidationError: function() {
        if (
          this.serverData.clinic_name_err !== '' ||
          this.serverData.clinic_street_err !== '' ||
          this.serverData.clinic_district_err !== '' ||
          this.serverData.clinic_city_err !== '' ||
          this.serverData.clinic_contact_number_err !== ''
        ) {
          return true
        }
        return false
      }
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-1">
    <form action="<?php echo URLROOT; ?>/pages/personalInfo" method="post">
      <!-- <div class="text-black text-center">
      <?php flash('update_success'); ?>
      </div> -->

      <header class="flex items-center justify-between gap-3 mb-10">
        <div class="w-64 flex-shrink-0">
          <span class="text-lg font-medium">Personal information</span>
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
        <!-- First name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            First name
          </label>
          <input type="text" value="<?php echo $data['first_name'] ?>" x-bind="formGroup.formInput" name="first_name">
          <?php if (!empty($data['first_name_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['first_name_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Middle name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Middle name
          </label>
          <input type="text" value="<?php echo $data['middle_name'] ?>" x-bind="formGroup.formInput" name="middle_name">
          <?php if (!empty($data['middle_name_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['middle_name_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Last name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Last name
          </label>
          <input type="text" value="<?php echo $data['last_name'] ?>" x-bind="formGroup.formInput" name="last_name">
          <?php if (!empty($data['last_name_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['last_name_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Date of birth -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Date of Birth
          </label>
          <input type="date" value="<?php echo $data['birthdate'] ?>" x-bind="formGroup.formInput" name="birthdate">
          <?php if (!empty($data['birthdate_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['birthdate_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Gender -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Gender
          </label>
          <select x-bind="formGroup.formInput" name="gender">
            <option value="">Select</option>
            <option <?php if ($data['gender'] == 'Female') : ?> selected <?php endif; ?> value="Female">Female</option>
            <option <?php if ($data['gender'] == 'Male') : ?> selected <?php endif; ?> value="Male">Male</option>
          </select>
          <?php if (!empty($data['gender_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['gender_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Contact no -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Contact number
          </label>
          <input type="text" value="<?php echo $data['contact_number'] ?>" x-bind="formGroup.formInput" name="contact_number">
          <?php if (!empty($data['contact_number_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['contact_number_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Facebook account name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Facebook account name
          </label>
          <input type="text" value="<?php echo $data['fb_account_name'] ?>" x-bind="formGroup.formInput" name="fb_account_name">
          <?php if (!empty($data['fb_account_name_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['fb_account_name_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Home address -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Home address
          </label>
          <input type="text" value="<?php echo $data['address'] ?>" x-bind="formGroup.formInput" name="address">
          <?php if (!empty($data['address_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['address_err']; ?> !
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
          this.serverData.first_name_err !== '' ||
          this.serverData.middle_name_err !== '' ||
          this.serverData.last_name_err !== '' ||
          this.serverData.gender_err !== '' ||
          this.serverData.fb_account_name_err !== '' ||
          this.serverData.contact_number_err !== '' ||
          this.serverData.birthdate_err !== '' ||
          this.serverData.address_err !== ''
        ) {
          return true
        }
        return false
      }
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-1">
    <form action="<?php echo URLROOT; ?>/pages/licenseInfo" method="POST">
      <!-- <div class="text-black text-center">
        <?php flash('update_success'); ?>
      </div> -->

      <header class="flex items-center justify-between gap-3 mb-10">
        <div class="w-64 flex-shrink-0">
          <span class="text-lg font-medium">License information</span>
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
        <!-- License no -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            PRC license no
          </label>
          <input type="number" value="<?php echo $data['prc_number'] ?>" x-bind="formGroup.formInput" name="prc_number">
          <?php if (!empty($data['prc_number_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['prc_number_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Registration date -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Registration date
          </label>
          <input type="date" value="<?php echo $data['prc_registration_date'] ?>" x-bind="formGroup.formInput" name="prc_registration_date">
          <?php if (!empty($data['prc_registration_date_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['prc_registration_date_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Expiration date -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Expiration date
          </label>
          <input type="date" value="<?php echo $data['prc_expiration_date'] ?>" x-bind="formGroup.formInput" name="prc_expiration_date">
          <?php if (!empty($data['prc_expiration_date_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['prc_expiration_date_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Field of practice -->
        <div x-bind="formGroup" x-data="{specified: false}">
          <label x-bind="formGroup.formLabel">
            Field of practice
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && !specified">Specify</a>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Select</a>
          </label>
          <input type="text" value="<?php echo $data['field_practice'] ?>" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="field_practice" placeholder="Specify your field of practice">
          <select x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="field_practice">
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
            <div x-bind="formGroup.formInputError">
              <?php echo $data['field_practice_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Type of practice -->
        <div x-bind="formGroup" x-data="{specified: false}">
          <label x-bind="formGroup.formLabel">
            Type of practice
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && !specified">Specify</a>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Select</a>
          </label>
          <input type="text" value="<?php echo $data['type_practice'] ?>" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="type_practice" placeholder="Specify your type of practice">
          <select x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="type_practice">
            <option value="">Select</option>
            <option <?php if ($data['type_practice'] == 'Government Dentist') : ?> selected <?php endif; ?> value="Government Dentist">Government Dentist</option>
            <option <?php if ($data['type_practice'] == 'Clinic Owner') : ?> selected <?php endif; ?> value="Clinic Owner">Clinic Owner</option>
            <option <?php if ($data['type_practice'] == 'Dental Associate') : ?> selected <?php endif; ?> value="Dental Associate">Dental Associate</option>
            <option <?php if ($data['type_practice'] == 'School Dentist') : ?> selected <?php endif; ?> value="School Dentist">School Dentist</option>
            <option <?php if ($data['type_practice'] == 'None Practicing') : ?> selected <?php endif; ?> value="None Practicing">None Practicing</option>
          </select>
          <?php if (!empty($data['type_practice_err'])) : ?>
            <div x-bind="formGroup.formInputError">
              <?php echo $data['type_practice_err']; ?> !
            </div>
          <?php endif; ?>
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
          this.serverData.prc_number_err !== '' ||
          this.serverData.prc_registration_date_err !== '' ||
          this.serverData.prc_expiration_date_err !== '' ||
          this.serverData.field_practice_err !== '' ||
          this.serverData.type_practice_err !== ''
        ) {
          return true
        }
        return false
      }
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
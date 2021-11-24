<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full">
  <div class="text-black text-center">
    <?php flash('login_status'); ?>
  </div>

  <header class="flex justify-content-between px-4 sm:px-0" x-data="{isEditMode: false}">
    <div class="w-64 flex-shrink-0">
      <span class="text-lg font-medium leading-6 text-gray-900">Payment History</span>
      <p class="mt-1 text-sm text-gray-600">
        Use a permanent address where you can receive mail.
      </p>
    </div>
    <!-- <div class="w-full text-right">
      <a class="text-blue-400 hover:underline cursor-pointer" x-show="!isEditMode" x-on:click="isEditMode = !isEditMode">Enable editing</a>
      <a class="text-blue-400 hover:underline cursor-pointer" x-show="isEditMode" x-on:click="isEditMode = !isEditMode">Disable editing</a>
    </div> -->
  </header>

  <div class="overflow-x-auto mt-9">
    <div class="align-middle inline-block min-w-full px-1">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Year
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Payment
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Payment option
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                2021
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm text-gray-900">
                  900.00
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                Paypal
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                  Not verified
                </span>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                2020
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm text-gray-900">
                  900.00
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                Paypal
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Verified
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>
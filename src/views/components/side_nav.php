<aside
  class="block xl:block sm:hidden sidebar-wrapper w-[308px] fixed top-0 bg-white dark:bg-darkblack-600 h-full z-30 flex flex-col items-center">
  <div
    class="sidebar-header relative border-r border-b border-r-[#F7F7F7] border-b-[#F7F7F7] dark:border-darkblack-400 w-full h-[108px] flex items-center justify-center z-30">
    <a href="<?= BASE_ENDPOINT ?>/">
      <img src="<?= ASSETS_URL ?>/images/logo/logo-text.png" class="block" alt="logo" width="130" height="130" />
    </a>
    <button type="button" class="drawer-btn absolute right-0 top-auto" title="Ctrl+b">
      <span>
        <svg width="16" height="40" viewBox="0 0 16 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z" fill="#22C55E" />
          <path d="M10 15L6 20.0049L10 25.0098" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </span>
    </button>
  </div>
  <div
    class="sidebar-body pl-[48px] pt-[14px] w-full relative z-30 h-screen overflow-style-none overflow-y-scroll pb-[200px]">
    <div class="nav-wrapper pr-[50px] mb-[36px]">
      <div class="item-wrapper mb-5">
        <ul class="mt-2.5">
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <a href="<?= BASE_ENDPOINT ?>/tasks/add">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <i class="fa-solid fa-circle-plus text-xl" style="color: #22c55e;"></i>
                  <span class="item-text text-lg font-medium leading-none">Add Task</span>
                </div>
              </div>
            </a>
          </li>
        </ul>
        <h4
          class="text-sm font-medium dark:text-bgray-50 text-bgray-700 border-b dark:border-darkblack-400 border-bgray-200 leading-7">
        </h4>
        <ul class="mt-2.5">
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <a href="<?= BASE_ENDPOINT ?>/">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <span class="item-ico">
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                        fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                        fill="#22C55E" class="path-2" />
                      <path
                        d="M11 0H7C5.89543 0 5 0.895431 5 2C5 3.10457 5.89543 4 7 4H11C12.1046 4 13 3.10457 13 2C13 0.895431 12.1046 0 11 0Z"
                        fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                  <span class="item-text text-lg font-medium leading-none">Today</span>
                </div>
              </div>
            </a>
          </li>
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <a href="<?= BASE_ENDPOINT ?>/upcoming">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <span class="item-ico">
                    <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                        fill="#1A202C" class="path-1" />
                      <path d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                        fill="#1A202C" class="path-2" />
                      <circle cx="9" cy="14" r="1" fill="#22C55E" />
                      <circle cx="13" cy="14" r="1" fill="#22C55E" class="path-2" />
                      <circle cx="5" cy="14" r="1" fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                  <span class="item-text text-lg font-medium leading-none">Upcoming</span>
                </div>
              </div>
            </a>
          </li>
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <a href="<?= BASE_ENDPOINT ?>/filters">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <span class="item-ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M1.57666 3.61499C1.57666 2.51042 2.47209 1.61499 3.57666 1.61499H8.5C9.60456 1.61499 10.5 2.51042 10.5 3.61499V8.53833C10.5 9.64289 9.60456 10.5383 8.49999 10.5383H3.57666C2.47209 10.5383 1.57666 9.64289 1.57666 8.53832V3.61499Z"
                        fill="#1A202C" class="path-1" />
                      <path
                        d="M13.5 15.5383C13.5 14.4338 14.3954 13.5383 15.5 13.5383H20.4233C21.5279 13.5383 22.4233 14.4338 22.4233 15.5383V20.4617C22.4233 21.5662 21.5279 22.4617 20.4233 22.4617H15.5C14.3954 22.4617 13.5 21.5662 13.5 20.4617V15.5383Z"
                        fill="#1A202C" class="path-1" />
                      <circle cx="6.03832" cy="18" r="4.46166" fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M18 2C18.4142 2 18.75 2.33579 18.75 2.75V5.25H21.25C21.6642 5.25 22 5.58579 22 6C22 6.41421 21.6642 6.75 21.25 6.75H18.75V9.25C18.75 9.66421 18.4142 10 18 10C17.5858 10 17.25 9.66421 17.25 9.25V6.75H14.75C14.3358 6.75 14 6.41421 14 6C14 5.58579 14.3358 5.25 14.75 5.25H17.25V2.75C17.25 2.33579 17.5858 2 18 2Z"
                        fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                  <span class="item-text text-lg font-medium leading-none">Filters</span>
                </div>
              </div>
            </a>
          </li>
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <a href="<?= BASE_ENDPOINT ?>/archived">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <span class="item-ico">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M18 11C18 15.9706 13.9706 20 9 20C4.02944 20 0 15.9706 0 11C0 6.02944 4.02944 2 9 2C13.9706 2 18 6.02944 18 11Z"
                        fill="#1A202C" class="path-1" />
                      <path
                        d="M19.8025 8.01277C19.0104 4.08419 15.9158 0.989557 11.9872 0.197453C10.9045 -0.0208635 10 0.89543 10 2V8C10 9.10457 10.8954 10 12 10H18C19.1046 10 20.0209 9.09555 19.8025 8.01277Z"
                        fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                  <span class="item-text text-lg font-medium leading-none">Archived</span>
                </div>
              </div>
            </a>
          </li>
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <a class="cursor-pointer">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <span class="item-ico">
                    <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M17.5 12.5C17.5 17.1944 13.6944 21 9 21C4.30558 21 0.5 17.1944 0.5 12.5C0.5 7.80558 4.30558 4 9 4C13.6944 4 17.5 7.80558 17.5 12.5Z"
                        fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.99995 1.75C8.02962 1.75 7.09197 1.88462 6.20407 2.13575C5.80549 2.24849 5.39099 2.01676 5.27826 1.61818C5.16553 1.21961 5.39725 0.805108 5.79583 0.692376C6.81525 0.404046 7.89023 0.25 8.99995 0.25C10.1097 0.25 11.1846 0.404046 12.2041 0.692376C12.6026 0.805108 12.8344 1.21961 12.7216 1.61818C12.6089 2.01676 12.1944 2.24849 11.7958 2.13575C10.9079 1.88462 9.97028 1.75 8.99995 1.75Z"
                        fill="#22C55E" class="path-2" />
                      <path
                        d="M11 13C11 14.1046 10.1046 15 9 15C7.89543 15 7 14.1046 7 13C7 11.8954 7.89543 11 9 11C10.1046 11 11 11.8954 11 13Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9 7.25C9.41421 7.25 9.75 7.58579 9.75 8V12C9.75 12.4142 9.41421 12.75 9 12.75C8.58579 12.75 8.25 12.4142 8.25 12V8C8.25 7.58579 8.58579 7.25 9 7.25Z"
                        fill="#22C55E" class="path-2" />
                    </svg>

                  </span>
                  <span class="item-text text-lg font-medium leading-none">Reminders</span>
                </div>
                <span>
                  <svg width="6" height="12" viewBox="0 0 6 12" fill="none" class="fill-current"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"
                      d="M0.531506 0.414376C0.20806 0.673133 0.155619 1.1451 0.414376 1.46855L4.03956 6.00003L0.414376 10.5315C0.155618 10.855 0.208059 11.3269 0.531506 11.5857C0.854952 11.8444 1.32692 11.792 1.58568 11.4685L5.58568 6.46855C5.80481 6.19464 5.80481 5.80542 5.58568 5.53151L1.58568 0.531506C1.32692 0.20806 0.854953 0.155619 0.531506 0.414376Z" />
                  </svg>
                </span>
              </div>
            </a>
            <ul class="sub-menu mt-[22px] ml-2.5 pl-5 border-l border-success-100">
              <li>
                <a href="<?= BASE_ENDPOINT ?>/reminders/add"
                  class="text-md font-medium text-bgray-600 dark:text-bgray-50 hover:dark:text-success-300 transition-all py-1.5 inline-block hover:text-bgray-800">Add</a>
              </li>
              <li>
                <a href="<?= BASE_ENDPOINT ?>/reminders/list"
                  class="text-md font-medium text-bgray-600 dark:text-bgray-50 hover:dark:text-success-300 transition-all py-1.5 inline-block hover:text-bgray-800">List</a>
              </li>
              <li>
                <a href="<?= BASE_ENDPOINT ?>/reminders/history"
                  class="text-md font-medium text-bgray-600 dark:text-bgray-50 hover:dark:text-success-300 transition-all py-1.5 inline-block hover:text-bgray-800">History</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="item-wrapper mb-5">
        <h4
          class="text-sm font-medium text-bgray-700 dark:text-bgray-50 border-b border-bgray-200 dark:border-darkblack-400 leading-7">
        </h4>
        <ul class="mt-2.5">
          <li class="item py-[11px] text-bgray-900 dark:text-white">
            <button onclick="logout()">
              <div class="flex items-center justify-between">
                <div class="flex space-x-2.5 items-center">
                  <span class="item-ico">
                    <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M17.1464 10.4394C16.8536 10.7323 16.8536 11.2072 17.1464 11.5001C17.4393 11.7929 17.9142 11.7929 18.2071 11.5001L19.5 10.2072C20.1834 9.52375 20.1834 8.41571 19.5 7.73229L18.2071 6.4394C17.9142 6.1465 17.4393 6.1465 17.1464 6.4394C16.8536 6.73229 16.8536 7.20716 17.1464 7.50006L17.8661 8.21973H11.75C11.3358 8.21973 11 8.55551 11 8.96973C11 9.38394 11.3358 9.71973 11.75 9.71973H17.8661L17.1464 10.4394Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.75 17.75H12C14.6234 17.75 16.75 15.6234 16.75 13C16.75 12.5858 16.4142 12.25 16 12.25C15.5858 12.25 15.25 12.5858 15.25 13C15.25 14.7949 13.7949 16.25 12 16.25H8.21412C7.34758 17.1733 6.11614 17.75 4.75 17.75ZM8.21412 1.75H12C13.7949 1.75 15.25 3.20507 15.25 5C15.25 5.41421 15.5858 5.75 16 5.75C16.4142 5.75 16.75 5.41421 16.75 5C16.75 2.37665 14.6234 0.25 12 0.25H4.75C6.11614 0.25 7.34758 0.82673 8.21412 1.75Z"
                        fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 5C0 2.37665 2.12665 0.25 4.75 0.25C7.37335 0.25 9.5 2.37665 9.5 5V13C9.5 15.6234 7.37335 17.75 4.75 17.75C2.12665 17.75 0 15.6234 0 13V5Z"
                        fill="#1A202C" class="path-1" />
                    </svg>
                  </span>
                  <span class="item-text text-lg font-medium leading-none">Logout</span>
                </div>
              </div>
            </button>
          </li>
        </ul>
      </div>
    </div>
    <div class="copy-write-text">
      <p class="text-sm text-[#969BA0]"> 2025 All Rights Reserved</p>
      <p class="text-sm text-bgray-700 font-medium">
        Individual Assignment
        <br>
        <strong>
          Web Programming
        </strong>
        <br>
        <a href="https://newinti.edu.my/" target="_blank" class="font-semibold border-b hover:text-blue-600">INTI
          INTERNATIONAL UNIVERSITY</a>
      </p>
    </div>
  </div>
</aside>

<div style="z-index: 25" class="aside-overlay block sm:hidden w-full h-full fixed left-0 top-0 bg-black bg-opacity-30">
</div>
<aside class="sm:block hidden relative w-[96px] bg-white dark:bg-black">
  <div class="w-full sidebar-wrapper-collapse relative top-0 z-30">
    <div
      class="sidebar-header bg-white dark:bg-darkblack-600 dark:border-darkblack-500 sticky top-0 border-r border-b border-r-[#F7F7F7] border-b-[#F7F7F7] w-full h-[108px] flex items-center justify-center z-20">
      <a href="<?= BASE_ENDPOINT ?>/">
        <img src="<?= ASSETS_URL ?>/images/logo/logo.png" class="block" alt="logo" width="50" height="50" />
      </a>
    </div>
    <div class="sidebar-body pt-[14px] w-full">
      <div class="flex flex-col min-h-screen justify-between">
        <div class="nav-wrapper mb-[36px]">
          <div class="item-wrapper mb-5">
            <ul class="mt-2.5 space-y-2">
              <!-- Add Task -->
              <li class="item py-[11px] px-[43px]">
                <a href="<?= BASE_ENDPOINT ?>/tasks/add">
                  <span class="item-ico">
                    <i class="fa-solid fa-circle-plus text-xl" style="color: #22c55e;"></i>
                  </span>
                </a>
              </li>

              <!-- Today -->
              <li class="item py-[11px] px-[43px]">
                <a href="<?= BASE_ENDPOINT ?>/">
                  <span class="item-ico">
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                        fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                        fill="#22C55E" class="path-2" />
                      <path
                        d="M11 0H7C5.89543 0 5 0.895431 5 2C5 3.10457 5.89543 4 7 4H11C12.1046 4 13 3.10457 13 2C13 0.895431 12.1046 0 11 0Z"
                        fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                </a>
              </li>

              <!-- Upcoming -->
              <li class="item py-[11px] px-[43px]">
                <a href="<?= BASE_ENDPOINT ?>/upcoming">
                  <span class="item-ico">
                    <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                        fill="#1A202C" class="path-1" />
                      <path d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                        fill="#1A202C" class="path-2" />
                      <circle cx="9" cy="14" r="1" fill="#22C55E" />
                      <circle cx="13" cy="14" r="1" fill="#22C55E" class="path-2" />
                      <circle cx="5" cy="14" r="1" fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                </a>
              </li>
              <li class="item py-[11px] px-[43px]">
                <a href="<?= BASE_ENDPOINT ?>/filters">
                  <span class="item-ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M1.57666 3.61499C1.57666 2.51042 2.47209 1.61499 3.57666 1.61499H8.5C9.60456 1.61499 10.5 2.51042 10.5 3.61499V8.53833C10.5 9.64289 9.60456 10.5383 8.49999 10.5383H3.57666C2.47209 10.5383 1.57666 9.64289 1.57666 8.53832V3.61499Z"
                        fill="#1A202C" class="path-1" />
                      <path
                        d="M13.5 15.5383C13.5 14.4338 14.3954 13.5383 15.5 13.5383H20.4233C21.5279 13.5383 22.4233 14.4338 22.4233 15.5383V20.4617C22.4233 21.5662 21.5279 22.4617 20.4233 22.4617H15.5C14.3954 22.4617 13.5 21.5662 13.5 20.4617V15.5383Z"
                        fill="#1A202C" class="path-1" />
                      <circle cx="6.03832" cy="18" r="4.46166" fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M18 2C18.4142 2 18.75 2.33579 18.75 2.75V5.25H21.25C21.6642 5.25 22 5.58579 22 6C22 6.41421 21.6642 6.75 21.25 6.75H18.75V9.25C18.75 9.66421 18.4142 10 18 10C17.5858 10 17.25 9.66421 17.25 9.25V6.75H14.75C14.3358 6.75 14 6.41421 14 6C14 5.58579 14.3358 5.25 14.75 5.25H17.25V2.75C17.25 2.33579 17.5858 2 18 2Z"
                        fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                </a>
              </li>
              <li class="item py-[11px] px-[43px]">
                <a href="<?= BASE_ENDPOINT ?>/archived">
                  <span class="item-ico">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M18 11C18 15.9706 13.9706 20 9 20C4.02944 20 0 15.9706 0 11C0 6.02944 4.02944 2 9 2C13.9706 2 18 6.02944 18 11Z"
                        fill="#1A202C" class="path-1" />
                      <path
                        d="M19.8025 8.01277C19.0104 4.08419 15.9158 0.989557 11.9872 0.197453C10.9045 -0.0208635 10 0.89543 10 2V8C10 9.10457 10.8954 10 12 10H18C19.1046 10 20.0209 9.09555 19.8025 8.01277Z"
                        fill="#22C55E" class="path-2" />
                    </svg>
                  </span>
                </a>
              </li>
              <li class="item py-[11px] px-[43px]">
                <a href="<?= BASE_ENDPOINT ?>/reminders/list">
                  <span class="item-ico">
                    <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M17.5 12.5C17.5 17.1944 13.6944 21 9 21C4.30558 21 0.5 17.1944 0.5 12.5C0.5 7.80558 4.30558 4 9 4C13.6944 4 17.5 7.80558 17.5 12.5Z"
                        fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.99995 1.75C8.02962 1.75 7.09197 1.88462 6.20407 2.13575C5.80549 2.24849 5.39099 2.01676 5.27826 1.61818C5.16553 1.21961 5.39725 0.805108 5.79583 0.692376C6.81525 0.404046 7.89023 0.25 8.99995 0.25C10.1097 0.25 11.1846 0.404046 12.2041 0.692376C12.6026 0.805108 12.8344 1.21961 12.7216 1.61818C12.6089 2.01676 12.1944 2.24849 11.7958 2.13575C10.9079 1.88462 9.97028 1.75 8.99995 1.75Z"
                        fill="#22C55E" class="path-2" />
                      <path
                        d="M11 13C11 14.1046 10.1046 15 9 15C7.89543 15 7 14.1046 7 13C7 11.8954 7.89543 11 9 11C10.1046 11 11 11.8954 11 13Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9 7.25C9.41421 7.25 9.75 7.58579 9.75 8V12C9.75 12.4142 9.41421 12.75 9 12.75C8.58579 12.75 8.25 12.4142 8.25 12V8C8.25 7.58579 8.58579 7.25 9 7.25Z"
                        fill="#22C55E" class="path-2" />
                    </svg>

                  </span>
                </a>
                <ul class="sub-menu border-l border-success-100 bg-white px-5 py-2 rounded-lg shadow-lg min-w-[200px]">
                  <li>
                    <a href="<?= BASE_ENDPOINT ?>/reminders/add"
                      class="text-md font-medium text-bgray-600 py-1.5 inline-block hover:text-bgray-800">Add</a>
                  </li>
                  <li>
                    <a href="<?= BASE_ENDPOINT ?>/reminders/list"
                      class="text-md font-medium text-bgray-600 py-1.5 inline-block hover:text-bgray-800">List</a>
                  </li>
                  <li>
                    <a href="<?= BASE_ENDPOINT ?>/reminders/history"
                      class="text-md font-medium text-bgray-600 py-1.5 inline-block hover:text-bgray-800">History</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="item-wrapper mb-5">
            <ul class="mt-2.5 flex justify-center items-center flex-col">
              <li class="item py-[11px] px-[43px]">
                <a href="#">
                  <span class="item-ico">
                    <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M17.1464 10.4394C16.8536 10.7323 16.8536 11.2072 17.1464 11.5001C17.4393 11.7929 17.9142 11.7929 18.2071 11.5001L19.5 10.2072C20.1834 9.52375 20.1834 8.41571 19.5 7.73229L18.2071 6.4394C17.9142 6.1465 17.4393 6.1465 17.1464 6.4394C16.8536 6.73229 16.8536 7.20716 17.1464 7.50006L17.8661 8.21973H11.75C11.3358 8.21973 11 8.55551 11 8.96973C11 9.38394 11.3358 9.71973 11.75 9.71973H17.8661L17.1464 10.4394Z"
                        fill="#22C55E" class="path-2" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.75 17.75H12C14.6234 17.75 16.75 15.6234 16.75 13C16.75 12.5858 16.4142 12.25 16 12.25C15.5858 12.25 15.25 12.5858 15.25 13C15.25 14.7949 13.7949 16.25 12 16.25H8.21412C7.34758 17.1733 6.11614 17.75 4.75 17.75ZM8.21412 1.75H12C13.7949 1.75 15.25 3.20507 15.25 5C15.25 5.41421 15.5858 5.75 16 5.75C16.4142 5.75 16.75 5.41421 16.75 5C16.75 2.37665 14.6234 0.25 12 0.25H4.75C6.11614 0.25 7.34758 0.82673 8.21412 1.75Z"
                        fill="#1A202C" class="path-1" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 5C0 2.37665 2.12665 0.25 4.75 0.25C7.37335 0.25 9.5 2.37665 9.5 5V13C9.5 15.6234 7.37335 17.75 4.75 17.75C2.12665 17.75 0 15.6234 0 13V5Z"
                        fill="#1A202C" class="path-1" />
                    </svg>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</aside>

<script>
  async function logout() {
    const result = await swalWithBootstrapButtons.fire({
      title: "Are you sure?",
      text: "Your sessions and cookies will be deleted!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, logout!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    });

    if (result.isConfirmed) {
      try {
        const response = await fetch("<?= BASE_ENDPOINT ?>/logout", {
          method: "POST",
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.error || "Something went wrong.");
        }

        await Swal.fire({
          icon: "success",
          title: data.message || "Logout successfully",
          timer: 2000,
          showConfirmButton: true
        });

        window.location.href = "<?= BASE_ENDPOINT ?>/login";

      } catch (error) {
        await Swal.fire({
          title: "Logout Failed!",
          text: error.message,
          icon: "error"
        });
      }
    } else {
      await swalWithBootstrapButtons.fire({
        title: "Cancelled",
        text: "Your session and cookies is not deleted :)",
        icon: "error"
      });
    }
  }
</script>
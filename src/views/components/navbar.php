<?php

require_once __DIR__ . "/../../services/ReminderService.php";
require_once __DIR__ . "/../../tools/tools.php";

$reminderService = new ReminderService();
$unreadNotifications = $reminderService->getAllUnreadReminders();

?>

<header class="md:block hidden header-wrapper w-full fixed z-30">
    <div
        class="w-full h-[108px] dark:bg-darkblack-600 bg-white flex items-center justify-between 2xl:px-[76px] px-10 relative">
        <button title="Ctrl+b" type="button" class="drawer-btn absolute left-0 top-auto transform rotate-180">
            <span>
                <svg width="16" height="40" viewBox="0 0 16 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z" fill="#22C55E" />
                    <path d="M10 15L6 20.0049L10 25.0098" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </span>
        </button>
        <!--              page-title-->
        <div>
            <h3 class="lg:text-3xl text-xl dark:text-bgray-50 text-bgray-900 font-bold lg:leading-[36.4px]">
                <?= ucfirst($nav_title) ?>
            </h3>
            <p class="lg:text-sm text-xs dark:text-bgray-50 text-bgray-600 font-medium lg:leading-[25.2px]">
                <?= ucfirst($slug) ?>
            </p>
        </div>
        <div class="quick-access-wrapper relative">
            <div class="flex space-x-[43px] items-center">
                <div class="xl:flex hidden space-x-5 items-center">
                    <button onclick="notificationAction()" id="notification-btn" type="button"
                        class="w-[52px] h-[52px] rounded-[12px] border border-success-300 dark:border-darkblack-400 flex justify-center items-center relative">
                        <?php if (count($unreadNotifications) > 0): ?>
                            <span
                                class="w-3.5 h-3.5 rounded-full bg-bgray-300 dark:bg-bgray-600 dark:border-none border-2 border-white absolute -right-[5px] -top-[2px]">
                            </span>
                        <?php endif; ?>
                        <svg class="fill-bgray-900 dark:fill-white" width="24" height="25" viewBox="0 0 24 25"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.9718 6.78149L19.2803 7.07178L19.9718 6.78149ZM19.3571 7.25473C19.5174 7.63666 19.957 7.81631 20.3389 7.65599C20.7209 7.49567 20.9005 7.05609 20.7402 6.67416L19.3571 7.25473ZM16.7784 2.77061C16.3937 2.61687 15.9573 2.80404 15.8036 3.18867C15.6498 3.5733 15.837 4.00973 16.2216 4.16347L16.7784 2.77061ZM16.6672 3.53388L16.3889 4.23031L16.6672 3.53388ZM4.0768 6.78149L4.76834 7.07178L4.0768 6.78149ZM3.30846 6.67416C3.14813 7.05609 3.32778 7.49567 3.70971 7.65599C4.09164 7.81631 4.53122 7.63666 4.69154 7.25473L3.30846 6.67416ZM7.82701 4.16347C8.21164 4.00973 8.39881 3.5733 8.24507 3.18867C8.09134 2.80405 7.65491 2.61687 7.27028 2.77061L7.82701 4.16347ZM7.38142 3.53388L7.10305 2.83745V2.83745L7.38142 3.53388ZM18.2395 9.93743L17.4943 10.0221V10.0221L18.2395 9.93743ZM18.6867 13.8746L19.4319 13.7899V13.7899L18.6867 13.8746ZM5.31328 13.8746L4.56807 13.7899L5.31328 13.8746ZM5.76046 9.93743L6.50567 10.0221L5.76046 9.93743ZM4.44779 15.83L3.87686 15.3436H3.87686L4.44779 15.83ZM19.5522 15.83L18.9813 16.3164L18.9813 16.3164L19.5522 15.83ZM14.2699 5.33931H13.5199C13.5199 5.65996 13.7238 5.94513 14.0272 6.04893L14.2699 5.33931ZM9.73005 5.33931L9.97284 6.04893C10.2762 5.94513 10.4801 5.65996 10.4801 5.33931H9.73005ZM15.7022 21.2175C15.8477 20.8296 15.6512 20.3973 15.2634 20.2518C14.8755 20.1064 14.4432 20.3029 14.2978 20.6907L15.7022 21.2175ZM9.70223 20.6907C9.55678 20.3029 9.12446 20.1064 8.73663 20.2518C8.34879 20.3973 8.15231 20.8296 8.29777 21.2175L9.70223 20.6907ZM19.2803 7.07178L19.3571 7.25473L20.7402 6.67416L20.6634 6.4912L19.2803 7.07178ZM16.2216 4.16347L16.3889 4.23031L16.9456 2.83745L16.7784 2.77061L16.2216 4.16347ZM20.6634 6.4912C19.9638 4.82468 18.6244 3.50849 16.9456 2.83745L16.3889 4.23031C17.6948 4.7523 18.7364 5.77599 19.2803 7.07178L20.6634 6.4912ZM3.38526 6.4912L3.30846 6.67416L4.69154 7.25473L4.76834 7.07178L3.38526 6.4912ZM7.27028 2.77061L7.10305 2.83745L7.65979 4.23031L7.82701 4.16347L7.27028 2.77061ZM4.76834 7.07178C5.31227 5.77599 6.35384 4.7523 7.65979 4.23031L7.10305 2.83745C5.4242 3.50849 4.08481 4.82468 3.38526 6.4912L4.76834 7.07178ZM17.7772 18.2056H6.22281V19.7056H17.7772V18.2056ZM17.4943 10.0221L17.9415 13.9592L19.4319 13.7899L18.9847 9.85279L17.4943 10.0221ZM6.05849 13.9592L6.50567 10.0221L5.01526 9.85279L4.56807 13.7899L6.05849 13.9592ZM5.01872 16.3164C5.59608 15.6386 5.96025 14.8241 6.05849 13.9592L4.56807 13.7899C4.50522 14.3432 4.2708 14.8812 3.87686 15.3436L5.01872 16.3164ZM17.9415 13.9592C18.0398 14.8241 18.4039 15.6386 18.9813 16.3164L20.1231 15.3436C19.7292 14.8812 19.4948 14.3432 19.4319 13.7899L17.9415 13.9592ZM6.22281 18.2056C5.5675 18.2056 5.10418 17.8817 4.89044 17.5053C4.68417 17.1421 4.68715 16.7056 5.01872 16.3164L3.87686 15.3436C3.11139 16.2422 3.0877 17.3685 3.5861 18.2461C4.07704 19.1105 5.04975 19.7056 6.22281 19.7056V18.2056ZM17.7772 19.7056C18.9503 19.7056 19.923 19.1105 20.4139 18.2461C20.9123 17.3685 20.8886 16.2422 20.1231 15.3436L18.9813 16.3164C19.3129 16.7056 19.3158 17.1421 19.1096 17.5053C18.8958 17.8817 18.4325 18.2056 17.7772 18.2056V19.7056ZM15.0199 5.33931V5.23567H13.5199V5.33931H15.0199ZM18.9847 9.85279C18.7054 7.39374 16.8802 5.43969 14.5127 4.6297L14.0272 6.04893C15.9445 6.70491 17.2914 8.23516 17.4943 10.0221L18.9847 9.85279ZM10.4801 5.33931V5.23567H8.98005V5.33931H10.4801ZM6.50567 10.0221C6.70863 8.23516 8.05551 6.70491 9.97284 6.04893L9.48727 4.6297C7.1198 5.43969 5.29456 7.39374 5.01526 9.85279L6.50567 10.0221ZM12 3.71741C12.84 3.71741 13.5199 4.39768 13.5199 5.23567H15.0199C15.0199 3.56821 13.6673 2.21741 12 2.21741V3.71741ZM12 2.21741C10.3327 2.21741 8.98005 3.56821 8.98005 5.23567H10.4801C10.4801 4.39768 11.16 3.71741 12 3.71741V2.21741ZM14.2978 20.6907C13.9752 21.5508 13.0849 22.2026 12 22.2026V23.7026C13.6851 23.7026 15.1514 22.686 15.7022 21.2175L14.2978 20.6907ZM12 22.2026C10.9151 22.2026 10.0248 21.5508 9.70223 20.6907L8.29777 21.2175C8.84856 22.686 10.3149 23.7026 12 23.7026V22.2026Z" />
                        </svg>
                    </button>
                    <button type="button" id="theme-toggle"
                        class="w-[52px] h-[52px] rounded-[12px] border border-success-300 dark:border-darkblack-400 flex justify-center items-center relative">
                        <span class="block dark:hidden">
                            <svg class="stroke-bgray-900" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.3284 14.8687C13.249 14.8687 9.13135 10.751 9.13135 5.67163C9.13135 4.74246 9.26914 3.84548 9.5254 3C5.74897 4.14461 3 7.65276 3 11.803C3 16.8824 7.11765 21 12.197 21C16.3472 21 19.8554 18.251 21 14.4746C20.1545 14.7309 19.2575 14.8687 18.3284 14.8687Z"
                                    stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="hidden  dark:block">
                            <svg class="stroke-bgray-900 dark:stroke-bgray-50" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="5" stroke-width="1.5" />
                                <path d="M12 2V4" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M12 20V22" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M20.6602 7L18.9281 8" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M5.07178 16L3.33973 17" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M3.33984 7L5.07189 8" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M18.9282 16L20.6603 17" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="xl:block hidden h-[48px] w-[1px] bg-bgray-300 dark:bg-darkblack-400"></div>
                <!--                author-->
                <div class="flex lg:space-x-3 space-x-0">
                    <div class="2xl:block hidden">
                        <div class="flex space-x-2.5 items-center">
                            <h3 class="text-base dark:text-white text-bgray-900 font-bold leading-[28px]">
                                <?= $_SESSION["fullname"] ?>
                            </h3>
                        </div>
                        <p class="text-sm font-medium leading-[20px] dark:text-bgray-50 text-bgray-600">
                            <?= $_SESSION["email"] ?>
                        </p>
                    </div>
                </div>
            </div>
            <!--                notification ,message, store-->
            <div class="notification-popup-wrapper">
                <div onclick="notificationAction()" id="noti-outside"
                    class="w-full h-full fixed -left-[43px] top-0 hidden"></div>
                <div id="notification-box" style="
                      filter: drop-shadow(12px 12px 40px rgba(0, 0, 0, 0.08));
                    "
                    class="w-[400px] bg-white dark:bg-darkblack-600 absolute -left-[347px] top-[81px] rounded-lg hidden">
                    <div class="w-full pt-[66px] pb-[75px] relative">
                        <div class="w-full h-[66px] flex justify-between items-center absolute left-0 top-0 px-8">
                            <h3 class="text-xl text-bgray-900 dark:text-white font-bold">
                                Notifications
                            </h3>
                        </div>
                        <ul class="w-full h-[335px] overflow-y-scroll scroll-style-1">
                            <?php foreach ($unreadNotifications as $notification): ?>
                                <li
                                    class="py-4 pl-6 pr-[50px] hover:bg-bgray-100 dark:hover:bg-darkblack-500 border-b border-bgray-200 dark:border-darkblack-400">
                                    <a
                                        onclick="markAsRead(<?= $notification['id'] ?>, false)" class="cursor-pointer">
                                        <div class="noti-item">
                                            <p class="font-medium text-sm text-bgray-600 dark:text-bgray-50 mb-1">
                                                <?= mb_strimwidth(ucfirst($notification['title']), 0, 300, "...") ?>
                                            </p>
                                            <span
                                                class="text-xs font-medium text-bgray-500"><?= timeAgo($notification['sended_at']) ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="w-full h-[75px] flex justify-between items-center absolute left-0 bottom-0 px-8">
                            <div>
                                <a onclick="markAsRead(0, true)" class="cursor-pointer">
                                    <div class="flex space-x-2 items-center">
                                        <?php if (count($unreadNotifications) > 0): ?>
                                            <span>
                                                <svg width="22" height="12" viewBox="0 0 22 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 6L11 11L21 1M1 6L6 11M11 6L16 1" stroke="#0CAF60"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <span class="text-sm font-semibold text-success-300">
                                                Mark all as read
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="md:hidden block mobile-wrapper w-full fixed z-20">
    <div class="w-full h-[80px] bg-white dark:bg-darkblack-600 flex justify-between items-center">
        <div class="w-full h-full flex items-center space-x-5">
            <button type="button" class="drawer-btn transform rotate-180">
                <span>
                    <svg width="16" height="40" viewBox="0 0 16 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z"
                            fill="#F7F7F7" />
                        <path d="M10 15L6 20.0049L10 25.0098" stroke="#A0AEC0" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
            <div>
                <a href="https://spaceraceit.com/">
                    <img src="<?= ASSETS_URL ?>/images/logo/logo-color.svg" class="block dark:hidden" alt="logo" />
                    <img src="<?= ASSETS_URL ?>/images/logo/logo-white.svg" class="hidden dark:block " alt="logo" />
                </a>
            </div>
        </div>
    </div>
</header>
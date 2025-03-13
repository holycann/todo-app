<?php include __DIR__ . '/../../layouts/header.php' ?>

<?php

$statusOptions = ['scheduled', 'sent', 'failed', 'read', 'unread'];

?>

<div class="w-full py-[20px] px-[24px] rounded-lg bg-white dark:bg-darkblack-600">
    <div class="flex flex-col space-y-5">
        <div class="table-content w-full overflow-x-auto">
            <table class="w-full">
                <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                    <td class="py-5 px-6 xl:px-0 w-[250px] lg:w-auto inline-block">
                        <div class="w-full flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">
                                Title</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0">
                        <div class="w-full flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">Message</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0">
                        <div class="flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-gray-50">
                                Task</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0">
                        <div class="flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-gray-50">
                                Reminder Time</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0 w-[165px]">
                        <div class="w-full flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">Status</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0"></td>
                </tr>

                <?php $no = 1; ?>
                <?php foreach ($reminders as $reminder): ?>
                    <?php

                    $statusClass = match ($reminder['status'] ?? null) {
                        'scheduled' => 'bg-bgray-600',
                        'sent' => 'bg-success-400',
                        'failed' => 'bg-danger-300',
                        'read' => 'bg-success-400',
                        'unread' => 'bg-warning-300',
                        default => 'bg-bgray-600'
                    };

                    ?>
                    <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                        <td class="py-5 px-6 xl:px-0">
                            <div class="w-full flex space-x-2.5 items-center">
                                <p class="font-semibold text-base text-bgray-900 dark:text-white">
                                    <?= mb_strimwidth(ucwords($reminder['title']), 0, 50, "...") ?>
                                </p>
                            </div>
                        </td>
                        <td class="py-5 px-6 xl:px-0">
                            <p class="font-medium text-base text-bgray-900 dark:text-bgray-50">
                                <?= mb_strimwidth($reminder['message'], 0, 50, "...") ?>
                            </p>
                        </td>
                        <td class="py-5 px-6 xl:px-0 w-[165px]">
                            <p class="text-base text-bgray-900 dark:text-white">
                                <?= $reminder['task_id'] > 0 ? ucwords($reminder['task_id']) : 'None' ?>
                            </p>
                        </td>
                        <td class="py-5 px-6 xl:px-0">
                            <p class="font-medium text-base text-bgray-900 dark:text-bgray-50">
                                <?php
                                $dueDate = new DateTime($reminder['reminder_time']);
                                echo $dueDate->format('d-m-Y H:i');
                                ?>
                            </p>
                        </td>
                        <td class="py-5 px-6 xl:px-0 w-[165px]">
                            <button type="button"
                                class="text-white <?= $statusClass ?> rounded-lg text-sm px-4 text-center me-2 mb-2 items-center">
                                <?= isset($reminder['status']) ? ucwords($reminder['status']) : 'No Status' ?>
                            </button>
                        </td>
                        <td class="py-5 px-6 xl:px-0">
                            <div class="flex justify-center">
                                <button type="button" id="dropdownButton<?= $no ?>"
                                    data-dropdown-toggle="dropdown<?= $no ?>">
                                    <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8 2.00024C8 2.55253 8.44772 3.00024 9 3.00024C9.55228 3.00024 10 2.55253 10 2.00024C10 1.44796 9.55228 1.00024 9 1.00024C8.44772 1.00024 8 1.44796 8 2.00024Z"
                                            stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M1 2.00024C1 2.55253 1.44772 3.00024 2 3.00024C2.55228 3.00024 3 2.55253 3 2.00024C3 1.44796 2.55228 1.00024 2 1.00024C1.44772 1.00024 1 1.44796 1 2.00024Z"
                                            stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M15 2.00024C15 2.55253 15.4477 3.00024 16 3.00024C16.5523 3.00024 17 2.55253 17 2.00024C17 1.44796 16.5523 1.00024 16 1.00024C15.4477 1.00024 15 1.44796 15 2.00024Z"
                                            stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>

                                <div id="dropdown<?= $no ?>"
                                    class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                    <ul class="py-2" aria-labelledby="dropdownButton">
                                        <li>
                                            <a href="<?= BASE_ENDPOINT . '/reminders/' . $reminder['id'] . '/detail' ?>"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Detail</a>
                                        </li>
                                        <li>
                                            <a href="<?= BASE_ENDPOINT . '/reminders/' . $reminder['id'] . '/edit' ?>"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                                        </li>
                                        <li>
                                            <a onclick="deleteData('<?= BASE_ENDPOINT . '/reminders/' ?>', <?= $reminder['id'] ?>, 'Reminder')"
                                                class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-black cursor-pointer">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
    function changeFilterText(value, elementId, dropdownId) {
        $("#" + elementId).text(value);
        $("#" + dropdownId).hide();
    }

    function filterReminder(url) {
        let category = document.getElementById("categoryFilterValue").textContent.toLowerCase();
        let priority = document.getElementById("priorityFilterValue").textContent.toLowerCase();
        let status = document.getElementById("statusFilterValue").textContent.toLowerCase();

        category = category === "select category" ? "" : category;
        priority = priority === "select priority" ? "" : priority;
        status = status === "select status" ? "" : status;

        const queryParams = new URLSearchParams();
        if (category) queryParams.append("category", category);
        if (priority) queryParams.append("priority", priority);
        if (status) queryParams.append("status", status);

        window.location.href = url + (queryParams.toString() ? `?${queryParams.toString()}` : "");
    }



</script>

<?php include __DIR__ . '/../../layouts/footer.php' ?>
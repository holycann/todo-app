<?php include __DIR__ . '/../layouts/header.php' ?>

<?php

$categoryOptions = ['assignments', 'discussions', 'activities', 'examinations'];
$priorityOptions = ['high', 'medium', 'low'];
$statusOptions = ['on-going', 'pending', 'completed'];

?>

<div class="w-full py-[20px] px-[24px] rounded-lg bg-white dark:bg-darkblack-600">
    <div class="flex flex-col space-y-5">
        <div class="filter-content w-full pt-4">
            <div class="grid lg:grid-cols-3 grid-cols-1 gap-4">
                <div class="w-full">
                    <p class="text-base text-bgray-900 dark:text-white leading-[24px] font-bold mb-2">
                        Category
                    </p>
                    <div class="w-full h-[56px] relative">
                        <button onclick="filterAction('#category-filter')" type="button"
                            class="w-full h-full rounded-lg bg-bgray-100 px-4 flex justify-between items-center relative dark:bg-darkblack-500">
                            <span class="text-base text-bgray-500" id="categoryFilterValue">Select category</span>
                            <span>
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.58203 8.3186L10.582 13.3186L15.582 8.3186" stroke="#A0AEC0"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                        <div id="category-filter"
                            class="rounded-lg w-full shadow-lg bg-white dark:bg-darkblack-500 absolute right-0 z-10 top-14 overflow-hidden hidden">
                            <ul>
                                <?php foreach ($categoryOptions as $option): ?>
                                    <li onclick="changeFilterText('<?= ucfirst($option) ?>', 'categoryFilterValue', 'category-filter')"
                                        class="text-sm text-black dark:text-white hover:dark:bg-darkblack-600 cursor-pointer px-5 py-2 hover:bg-bgray-100 font-semibold">
                                        <?= ucfirst($option) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <p class="text-base text-bgray-900 dark:text-white leading-[24px] font-bold mb-2">
                        Priority
                    </p>
                    <div class="w-full h-[56px] relative">
                        <button onclick="filterAction('#priority-filter')" type="button"
                            class="w-full h-full rounded-lg bg-bgray-100 px-4 flex justify-between items-center relative dark:bg-darkblack-500">
                            <span class="text-base text-bgray-500" id="priorityFilterValue">Select priority</span>
                            <span>
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.58203 8.3186L10.582 13.3186L15.582 8.3186" stroke="#A0AEC0"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                        <div id="priority-filter"
                            class="rounded-lg w-full shadow-lg bg-white dark:bg-darkblack-500 absolute right-0 z-10 top-14 overflow-hidden hidden">
                            <ul>
                                <?php foreach ($priorityOptions as $option): ?>
                                    <li onclick="changeFilterText('<?= ucfirst($option) ?>', 'priorityFilterValue', 'priority-filter')"
                                        class="text-sm  text-black dark:text-white hover:dark:bg-darkblack-600 cursor-pointer px-5 py-2 hover:bg-bgray-100 font-semibold">
                                        <?= ucfirst($option) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <p class="text-base text-bgray-900 dark:text-white leading-[24px] font-bold mb-2">
                        Status
                    </p>
                    <div class="w-full h-[56px] relative">
                        <button onclick="filterAction('#status-filter')" type="button"
                            class="w-full h-full rounded-lg bg-bgray-100 px-4 flex justify-between items-center relative dark:bg-darkblack-500">
                            <span class="text-base text-bgray-500" id="statusFilterValue">Select status</span>
                            <span>
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.58203 8.3186L10.582 13.3186L15.582 8.3186" stroke="#A0AEC0"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                        <div id="status-filter"
                            class="rounded-lg w-full shadow-lg bg-white dark:bg-darkblack-500 absolute right-0 z-10 top-14 overflow-hidden hidden">
                            <ul>
                                <?php foreach ($statusOptions as $option): ?>
                                    <li onclick="changeFilterText('<?= ucfirst($option) ?>', 'statusFilterValue', 'status-filter')"
                                        class="text-sm  text-black dark:text-white hover:dark:bg-darkblack-600 cursor-pointer px-5 py-2 hover:bg-bgray-100 font-semibold">
                                        <?= ucfirst($option) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <button onclick="filterTask('<?= BASE_ENDPOINT . '/filters' ?>')" type="button"
                    class="flex justify-center items-center bg-bgray-100 dark:bg-darkblack-500 dark:border-darkblack-500 border border-bgray-300 rounded-lg">
                    <div class="flex space-x-3 items-center py-2">
                        <span>
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.55169 13.5022H1.25098" stroke="#0CAF60" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10.3623 3.80984H16.663" stroke="#0CAF60" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.94797 3.75568C5.94797 2.46002 4.88981 1.40942 3.58482 1.40942C2.27984 1.40942 1.22168 2.46002 1.22168 3.75568C1.22168 5.05133 2.27984 6.10193 3.58482 6.10193C4.88981 6.10193 5.94797 5.05133 5.94797 3.75568Z"
                                    stroke="#0CAF60" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.2214 13.4632C17.2214 12.1675 16.1641 11.1169 14.8591 11.1169C13.5533 11.1169 12.4951 12.1675 12.4951 13.4632C12.4951 14.7589 13.5533 15.8095 14.8591 15.8095C16.1641 15.8095 17.2214 14.7589 17.2214 13.4632Z"
                                    stroke="#0CAF60" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text-base text-success-300 font-medium">Filters</span>
                    </div>
                </button>
                <button onclick="window.location.href='<?= BASE_ENDPOINT . '/filters' ?>'" type="button"
                    class="flex justify-center items-center bg-bgray-100 dark:bg-darkblack-500 dark:border-darkblack-500 border border-bgray-300 rounded-lg">
                    <div class="flex space-x-3 items-center py-2">
                        <span class="text-base text-danger font-medium">Reset Filter</span>
                    </div>
                </button>
            </div>
        </div>
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
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">Description</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0">
                        <div class="flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-gray-50">
                                Due Date</span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0 w-[165px]">
                        <div class="w-full flex space-x-2.5 items-center cursor-pointer" data-order="asc"
                            onclick="sortTask('<?= BASE_ENDPOINT . '/filters' ?>', 'category')">
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50"
                                id="category-sort">Category</span>
                            <span>
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.332 1.31567V13.3157" stroke="#718096" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.66602 11.3157L3.66602 13.3157L1.66602 11.3157" stroke="#718096"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3.66602 13.3157V1.31567" stroke="#718096" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.332 3.31567L10.332 1.31567L8.33203 3.31567" stroke="#718096"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0 w-[165px]">
                        <div class="w-full flex space-x-2.5 items-center cursor-pointer" data-order="asc"
                            onclick="sortTask('<?= BASE_ENDPOINT . '/filters' ?>', 'priority')">
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50"
                                id="priority-sort">Priority</span>
                            <span>
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.332 1.31567V13.3157" stroke="#718096" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.66602 11.3157L3.66602 13.3157L1.66602 11.3157" stroke="#718096"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3.66602 13.3157V1.31567" stroke="#718096" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.332 3.31567L10.332 1.31567L8.33203 3.31567" stroke="#718096"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0 w-[165px] cursor-pointer" data-order="asc"
                        onclick="sortTask('<?= BASE_ENDPOINT . '/filters' ?>', 'status')">
                        <div class="w-full flex space-x-2.5 items-center">
                            <span class="text-base font-medium text-bgray-600 dark:text-bgray-50"
                                id="status-sort">Status</span>
                            <span>
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.332 1.31567V13.3157" stroke="#718096" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.66602 11.3157L3.66602 13.3157L1.66602 11.3157" stroke="#718096"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3.66602 13.3157V1.31567" stroke="#718096" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.332 3.31567L10.332 1.31567L8.33203 3.31567" stroke="#718096"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </td>
                    <td class="py-5 px-6 xl:px-0"></td>
                </tr>

                <?php $no = 1; ?>
                <?php foreach ($tasks as $task): ?>
                    <?php

                    $priorityClass = match ($task['priority'] ?? null) {
                        'high' => 'bg-danger-300',
                        'medium' => 'bg-warning-300',
                        'low' => 'bg-success-400',
                        default => 'bg-bgray-600'
                    };

                    $statusClass = match ($task['status'] ?? null) {
                        'on-going' => 'bg-blue-300',
                        'pending' => 'bg-warning-300',
                        'completed' => 'bg-success-400',
                        default => 'bg-bgray-600'
                    };

                    ?>
                    <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                        <td class="py-5 px-6 xl:px-0">
                            <div class="w-full flex space-x-2.5 items-center">
                                <p class="font-semibold text-base text-bgray-900 dark:text-white">
                                    <?= mb_strimwidth(ucwords($task['title']), 0, 50, "...") ?>
                                </p>
                            </div>
                        </td>
                        <td class="py-5 px-6 xl:px-0">
                            <p class="font-medium text-base text-bgray-900 dark:text-bgray-50">
                                <?= mb_strimwidth($task['description'], 0, 50, "...") ?>
                            </p>
                        </td>
                        <td class="py-5 px-6 xl:px-0">
                            <p class="font-medium text-base text-bgray-900 dark:text-bgray-50">
                                <?php
                                $dueDate = new DateTime($task['due_date']);
                                echo $dueDate->format('d-m-Y H:i');
                                ?>
                            </p>
                        </td>
                        <td class="py-5 px-6 xl:px-0 w-[165px]">
                            <p class="text-base text-bgray-900 dark:text-white">
                                <?= isset($task['category']) ? ucwords($task['category']) : 'No Category' ?>
                            </p>
                        </td>
                        <td class="py-5 px-6 xl:px-0 w-[165px]">
                            <button type="button"
                                class="text-white <?= $priorityClass ?> rounded-lg text-sm px-4 text-center me-2 mb-2 items-center">
                                <?= isset($task['priority']) ? ucwords($task['priority']) : 'No Priority' ?>
                            </button>
                        </td>
                        <td class="py-5 px-6 xl:px-0 w-[165px]">
                            <button type="button"
                                class="text-white <?= $statusClass ?> rounded-lg text-sm px-4 text-center me-2 mb-2 items-center">
                                <?= isset($task['status']) ? ucwords($task['status']) : 'No Status' ?>
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
                                            <a href="<?= BASE_ENDPOINT . '/tasks/' . $task['id'] . '/detail' ?>"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Detail</a>
                                        </li>
                                        <li>
                                            <a href="<?= BASE_ENDPOINT . '/tasks/' . $task['id'] . '/edit' ?>"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                                        </li>
                                        <li>
                                            <a onclick="deleteData('<?= BASE_ENDPOINT . '/tasks' ?>', <?= $task['id'] ?>, 'Task')"
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

    function filterTask(url) {
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

    function sortTask(url, type) {
        const queryParams = new URLSearchParams(window.location.search);

        let currentOrder = queryParams.get("order") === "asc" ? "desc" : "asc";

        queryParams.set("sort", type);
        queryParams.set("order", currentOrder);

        window.location.href = url + "?" + queryParams.toString();
    }

</script>

<?php include __DIR__ . '/../layouts/footer.php' ?>
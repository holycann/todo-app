<?php

include __DIR__ . '/../../layouts/header.php';

$taskId = $task['id'] ?? 0;

?>

<div class="bg-white p-6 rounded-lg shadow mb-6 dark:bg-darkblack-600 text-black dark:text-white">
    <form id="<?= $taskId > 0 ? 'editTaskForm' : 'addTaskForm' ?>" class="space-y-4 text-black dark:text-white"
        action="<?= $taskId > 0 ? BASE_ENDPOINT . '/tasks/' . $taskId : BASE_ENDPOINT . '/tasks' ?>">

        <!-- Title and Category Row -->
        <div class="flex space-x-4">
            <div class="w-1/2">
                <label for="title" class="block text-sm font-medium text-black dark:text-white">Title</label>
                <input type="text" id="title" name="title" value="<?= $task['title'] ?? '' ?>"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white"
                    required>
            </div>
            <div class="w-1/2">
                <label for="category" class="block text-sm font-medium text-black dark:text-white">Category</label>
                <select id="category" name="category"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white"
                    required>

                    <?php
                    $categoryOptions = ['assignments', 'discussions', 'activities', 'examinations'];
                    $category = $task['category'] ?? '';

                    if (empty($category)) {
                        echo '<option value="" selected>-- Please Select Category ---</option>';
                    } else {
                        echo '<option value="' . $category . '" selected>' . ucfirst($category) . '</option>';
                    }

                    foreach ($categoryOptions as $option) {
                        if ($option !== $category) {
                            echo '<option value="' . $option . '">' . ucfirst($option) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-black dark:text-white">Description</label>
            <textarea id="description" name="description" rows="3"
                class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white"
                required><?= $task['description'] ?? '' ?></textarea>
        </div>

        <!-- Due Date and Priority Row -->
        <div class="flex space-x-4">
            <div class="w-1/2">
                <label for="due_date" class="block text-sm font-medium text-black dark:text-white">Due Date</label>
                <input type="datetime-local" id="due_date" name="due_date"
                    value="<?= $task['due_date'] ?? date('Y-m-d\TH:i', strtotime('+1 hour')) ?>"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white"
                    required>

            </div>
            <div class="w-1/2">
                <label for="priority" class="block text-sm font-medium text-black dark:text-white">Priority</label>
                <select id="priority" name="priority"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white">
                    <?php
                    $priorityOptions = ['high', 'medium', 'low'];
                    $priority = $task['priority'] ?? '';

                    if (empty($priority)) {
                        echo '<option value="" selected>-- Please Select Priority ---</option>';
                    } else {
                        echo '<option value="' . $priority . '" selected>' . ucfirst($priority) . '</option>';
                    }

                    foreach ($priorityOptions as $option) {
                        if ($option !== $priority) {
                            echo '<option value="' . $option . '">' . ucfirst($option) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- Status and Reminder Row -->
        <div class="flex space-x-4">
            <div class="w-1/2">
                <label for="status" class="block text-sm font-medium text-black dark:text-white">Status</label>
                <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white">
                    <?php
                    $statusOptions = ['on-going', 'pending', 'completed'];
                    $status = $task['status'] ?? '';

                    if (empty($status)) {
                        echo '<option value="" selected>-- Please Select Status ---</option>';
                    } else {
                        echo '<option value="' . $status . '" selected>' . ucfirst($status) . '</option>';
                    }

                    foreach ($statusOptions as $option) {
                        if ($option !== $status) {
                            echo '<option value="' . $option . '">' . ucfirst($option) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="w-1/2">
                <label for="reminder_time" class="block text-sm font-medium text-black dark:text-white">Reminder
                    Time</label>
                <input type="datetime-local" id="reminder_time" name="reminder_time" value="<?= $taskId > 0
                    ? ($reminder['reminder_time'] ?? '')
                    : ($taskId > 0 ? '' : date('Y-m-d\TH:i', strtotime('+30 minutes'))) ?>"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 pt-4">
            <button type="button"
                onclick="window.location.href='<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : BASE_ENDPOINT . '/' ?>'"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</button>
            <button type="button"
                onclick="postForm('<?= $taskId > 0 ? 'editTaskForm' : 'addTaskForm' ?>', '<?= $taskId > 0 ? BASE_ENDPOINT . '/tasks/' . $taskId . '/detail' : BASE_ENDPOINT . '/' ?>', '<?= $taskId > 0 ? 'put' : 'post' ?>')"
                class="px-4 py-2 text-sm font-medium text-white bg-success-400 rounded-md hover:bg-success-300 focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $taskId > 0 ? 'Edit' : 'Add' ?>
                Task</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $("<?= $taskId > 0 ? '#editTaskForm' : '#addTaskForm' ?>").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 5
                },
                category: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 10
                },
                due_date: {
                    required: true,
                    minDateTimeNow: true
                },
                reminder_time: {
                    required: true,
                    minReminderTime: "#due_date"
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title must be at least 5 characters"
                },
                category: {
                    required: "Category is required"
                },
                description: {
                    required: "Description is required",
                    minlength: "Description must be at least 10 characters"
                },
                due_date: {
                    required: "Due date is required",
                    minDateTimeNow: "Due date must be at least 1 hour after current time"
                },
                reminder_time: {
                    required: "Reminder time is required",
                    minReminderTime: "Reminder must be at least 30 minute before due date and at least 30 minute after time now"
                }
            }
        });

        $.validator.addMethod("minDateTimeNow", function (value, element) {
            var inputDate = new Date(value);
            var now = new Date();
            return inputDate > now;
        });

        $.validator.addMethod("minReminderTime", function (value, element, param) {
            var now = new Date();
            var reminderDate = new Date(value);
            var dueDate = new Date($(param).val());

            if (isNaN(reminderDate) || isNaN(dueDate)) {
                return false;
            }

            var minReminderTime = new Date(dueDate.getTime() - (60 * 30 * 1000));
            return reminderDate >= now && reminderDate <= minReminderTime;
        });
    });
</script>

<?php include __DIR__ . '/../../layouts/footer.php' ?>
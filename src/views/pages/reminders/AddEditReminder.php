<?php

include __DIR__ . '/../../layouts/header.php';

$reminderId = $reminder['id'] ?? 0;
$taskId = $task['id'] ?? 0;

?>

<div class="bg-white p-6 rounded-lg shadow mb-6 dark:bg-darkblack-600 text-black dark:text-white">
    <form id="<?= $reminderId > 0 ? 'editReminderForm' : 'addReminderForm' ?>"
        class="space-y-4 text-black dark:text-white"
        action="<?= $reminderId > 0 ? BASE_ENDPOINT . '/reminders/' . $reminderId : BASE_ENDPOINT . '/reminders' ?>">

        <!-- Title and Category Row -->
        <div class="flex space-x-4">
            <div class="w-full">
                <label for="title" class="block text-sm font-medium text-black dark:text-white">Title</label>
                <input type="text" id="title" name="title" value="<?= $reminder['title'] ?? '' ?>"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white"
                    required>
            </div>
        </div>

        <!-- Message -->
        <div>
            <label for="message" class="block text-sm font-medium text-black dark:text-white">Message</label>
            <textarea id="reminder_message" name="message" rows="3"
                class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white"
                required><?= $reminder['message'] ?? '' ?></textarea>
        </div>

        <div class="w-full">
            <label for="task_id" class="block text-sm font-medium text-black dark:text-white">Task</label>
            <select id="task_id" name="task_id"
                class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white">

                <?php
                if (empty($taskId)) {
                    echo '<option value="" selected>-- Select Task ---</option>';
                } else {
                    echo '<option value="' . $taskId . '" selected>' . mb_strimwidth(ucwords($task['title']), 0, 50, "...") . '</option>';
                }

                foreach ($tasks as $task) {
                    if ($task['id'] !== $taskId) {
                        echo '<option value="' . $task['id'] . '">' . mb_strimwidth(ucwords($task['title']), 0, 50, "...") . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Reminder Row -->
        <div class="flex space-x-4">
            <div class="w-full">
                <label for="reminder_time" class="block text-sm font-medium text-black dark:text-white">Reminder
                    Time</label>
                <input type="datetime-local" id="reminder_time" name="reminder_time" value="<?= $reminderId > 0
                    ? ($reminder['reminder_time'] ?? '')
                    : ($reminderId > 0 ? '' : date('Y-m-d\TH:i', strtotime('+30 minutes'))) ?>"
                    class="mt-1 block w-full rounded-md border-success-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-darkblack-500 dark:border-darkblack-400 text-black dark:text-white">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 pt-4">
            <button type="button"
                onclick="window.location.href='<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : BASE_ENDPOINT . '/' ?>'"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</button>
            <button type="button"
                onclick="postForm('<?= $reminderId > 0 ? 'editReminderForm' : 'addReminderForm' ?>', '<?= $reminderId > 0 ? BASE_ENDPOINT . '/reminders/' . $reminderId . '/detail' : BASE_ENDPOINT . '/upcoming' ?>', '<?= $reminderId > 0 ? 'put' : 'post' ?>')"
                class="px-4 py-2 text-sm font-medium text-white bg-success-400 rounded-md hover:bg-success-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?= $reminderId > 0 ? 'Update' : 'Add' ?> Reminder
            </button>

        </div>
    </form>
</div>


<script>
    $(document).ready(function () {
        $("<?= $reminderId > 0 ? '#editReminderForm' : '#addReminderForm' ?>").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 5
                },
                message: {
                    required: true,
                    minlength: 10
                },
                message: {
                    required: true,
                },
                reminder_time: {
                    required: true,
                    minReminderTime: "#reminder_time"
                }
            },
            messages: {
                title: {
                    required: "Title is required",
                    minlength: "Title must be at least 5 characters"
                },
                reminder_message: {
                    required: "Message is required",
                    minlength: "Description must be at least 10 characters"
                },
                reminder_time: {
                    required: "Reminder time is required",
                    minReminderTime: "Reminder must be at least 30 minute after time now"
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

            if (isNaN(reminderDate)) {
                return false;
            }

            return reminderDate >= now;
        });
    });
</script>


<?php include __DIR__ . '/../../layouts/footer.php' ?>
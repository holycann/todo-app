</section>
</div>
</main>
</div>
</div>
</div>

<script>
    document.querySelectorAll('[id="underline_select"]').forEach(select => {
        select.addEventListener('change', async function () {
            let taskId = this.dataset.taskId;
            let newStatus = this.value;

            try {
                let response = await fetch('<?= BASE_ENDPOINT ?>/tasks/' + taskId + '/status', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status: newStatus })
                });

                let data = await response.json();

                if (data) {
                    await Toast.fire({
                        icon: "success",
                        title: "Status Change successfully."
                    });
                    window.location.reload();
                } else {
                    console.error('Error:', data);
                    Toast.fire({
                        icon: "error",
                        title: "Status Change failed."
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Toast.fire({
                    icon: "error",
                    title: "Something went wrong!"
                });
            }
        });
    });
</script>

<script>
    async function deleteData(url, dataId, type) {
        const result = await swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "Your data will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(url + dataId, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' }
                });

                if (response) {
                    await Toast.fire({
                        icon: "success",
                        title: type + " deleted successfully."
                    });


                    if (window.location.href.includes(dataId)) {
                        if (window.location.href.includes('reminders')) {
                            window.location.href = document.referrer ? document.referrer : '<?= BASE_ENDPOINT ?>/reminders/list';
                        } else {
                            window.location.href = document.referrer ? document.referrer : '<?= BASE_ENDPOINT ?>/';
                        }
                    } else {
                        window.location.reload();
                    }
                } else {
                    await Toast.fire({
                        icon: "error",
                        title: "Failed to delete " + type + "."
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Toast.fire({
                    icon: "error",
                    title: "Something went wrong."
                });
            }
        } else {
            await swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Your data is still safe :)",
                icon: "error"
            });
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        try {
            const response = await fetch("<?= BASE_ENDPOINT ?>/reminders/sender");

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            console.log("Notification Sender:", data['message']);
        } catch (error) {
            console.error("Something Went Wrong:", error.message);
        }
    });
</script>

<script>
    async function markAsRead(notificationId, isReadAll = false) {
        var url = '<?= BASE_ENDPOINT ?>/reminders/read';

        if (!isReadAll) {
            url = '<?= BASE_ENDPOINT ?>/reminders/read/' + notificationId;
        }

        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' }
            });

            const data = await response.json();

            if (data) {
                if (isReadAll) {
                    Toast.fire({
                        icon: "success",
                        title: "Marked all as read successfully."
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    Toast.fire({
                        icon: "success",
                        title: "Marked task as read and Redirecting..."
                    });

                    setTimeout(() => {
                        window.location.href = "<?= BASE_ENDPOINT ?>/reminders/" + notificationId + '/detail';
                    }, 1500);
                }
            } else {
                Toast.fire({
                    icon: "error",
                    title: "Failed to mark as read."
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>

<script>
    async function postForm(formId, redirectUrl = "<?= BASE_ENDPOINT ?>/", method) {
        const form = document.getElementById(formId);

        if (!form) {
            console.error("Form with ID '" + formId + "' not found.");
            return;
        }

        event.preventDefault();

        const formData = new FormData(form);

        let dataBody;
        
        if(method == 'post') {
            dataBody = formData;
        } else {
            const objectData = {};
            formData.forEach((value, key) => {
                objectData[key] = value;
            });
            
            dataBody = JSON.stringify(objectData);
        }


        const response = await fetch(form.action, {
            method: method,
            body: dataBody
        });

        const data = await response.text();

        if (data.includes('Fatal error')) {
            const match = data.match(/Uncaught(.*?) in/s);

            await Toast.fire({
                icon: "error",
                title: "Request Failed",
                text: match ? match[1].trim() : "Unknown error"
            });
        } else {
            try {
                const jsonStart = data.lastIndexOf('{');
                if (jsonStart !== -1) {
                    const jsonString = data.substring(jsonStart);
                    const jsonData = JSON.parse(jsonString);
                    if (!jsonData.message) {
                        throw new Error(jsonData || "Something went wrong.");
                    }

                    await Toast.fire({
                        icon: "success",
                        title: jsonData.message || "Success!"
                    });

                    window.location.href = redirectUrl;
                } else {
                    console.error("Invalid response:", data);
                }
            } catch (error) {
            }
        }
    }
</script>

<script src="<?= ASSETS_URL ?>/js/flowbite.min.js"></script>
<script src="<?= ASSETS_URL ?>/js/aos.js"></script>
<script src="<?= ASSETS_URL ?>/js/slick.min.js"></script>

<script>
    AOS.init();
</script>

<script src="<?= ASSETS_URL ?>/js/main.js"></script>

</body>

</html>
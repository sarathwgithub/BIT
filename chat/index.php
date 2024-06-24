<?php
include '../../config.php';
include '../header.php';
?>
<style>
    #chat-box {
        width: 100%;
        height: 400px;
        border: 1px solid #ccc;
        overflow-y: scroll;
        margin-bottom: 10px;
        padding: 10px;
    }

    #chat-form {
        display: flex;
        justify-content: space-between;
    }

    #chat-form input[type="text"] {
        width: 90%;
        padding: 5px;
    }

    #chat-form button {
        padding: 5px 10px;
    }
</style>
<main id="main">
    <!-- ======= Contact Us Section ======= -->

    <div class="container">


        <h2>Chat Application</h2>

        <div id="chat-box"></div>
        <form id="chat-form">
            <input type="text" id="message" class="form-control border border-1 border-dark" placeholder="Type a message">
            <button type="submit" class="btn btn-warning">Send</button>
        </form>


    </div>
</main>
<?php
include '../footer.php';
?>

<script>
    $(document).ready(function() {
        function fetchMessages() {
            $.ajax({
                url: 'fetch_messages.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let chatBox = '';
                    data.forEach(function(message) {
                        chatBox += '<p><strong>' + message.username + ':</strong> ' + message.message + ' <em>(' + message.timestamp + ')</em></p>';
                    });
                    $('#chat-box').html(chatBox);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        }

        $('#chat-form').on('submit', function(event) {
            event.preventDefault();
            const message = $('#message').val();
            $.ajax({
                url: 'send_message.php',
                method: 'POST',
                data: {
                    message: message
                },
                success: function() {
                    $('#message').val('');
                    fetchMessages();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        });

        // Fetch messages every 2 seconds
        setInterval(fetchMessages, 2000);
        fetchMessages();
    });
</script>
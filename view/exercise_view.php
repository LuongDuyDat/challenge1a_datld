<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form {
            margin-bottom: 20px;
        }

        #assignmentList {
            margin-top: 20px;
        }

        #list {
            list-style-type: none;
            padding: 0;
        }

        .list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #ddd;
            padding: 10px;
        }

        .list-item i {
            margin-right: 10px;
            font-size: 20px;
        }

        .file-info {
            display: flex;
            flex-direction: column;  /* This should be column */
            align-items: flex-start;
            margin-right: 10px;
        }

        .file-name {
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
        }

        .size-uploader {
            display: contents;
            align-items: flex-end;
            text-align: right;
        }

        .size {
            font-size: 12px;
        }

        .uploader {
            font-size: 14px;
            color: #555;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php require base_path("controller/partition/header_controller.php")?>

    <div class="container">
        <h1>Assignment Upload</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            <label for="file">Choose File:</label>
            <input type="file" id="file" name="file" accept=".pdf, .docx" required>
            
            <button type="button" onclick="uploadFile()"><i class="fas fa-upload"></i> Upload</button>
        </form>

        <div id="assignmentList">
            <h2>Assignment List</h2>
            <ul id="list">
                <li class="list-item">
                    <div>
                        <i class="fas fa-file"></i>
                        <div class="file-name" style="display: inline-block;">Exercise1.pdf</div>
                    </div>
                        <div class="size-uploader">
                            <div class="size">10000 bytes</div>
                            <div class="uploader">John Doe</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        function uploadFile() {
            const assignmentName = document.getElementById('assignmentName').value;
            const fileInput = document.getElementById('file');
            const file = fileInput.files[0];

            if (assignmentName && file) {
                displayAssignment(assignmentName, file);
            } else {
                alert('Please enter assignment name and choose a file.');
            }
        }

        function displayAssignment(name, file) {
            const list = document.getElementById('list');
            const listItem = document.createElement('li');
            listItem.className = 'list-item';
            listItem.innerHTML = `
                <div>
                <i class="fas fa-file"></i>
                <div class="file-name" style="display: inline-block;">${name}</div>
                </div>
                <div class="size-uploader">
                        <div class="size">${file.size} bytes</div>
                        <div class="uploader">John Doe</div>
                    </div>
            `;
            list.appendChild(listItem);
        }
    </script>
</body>
</html>

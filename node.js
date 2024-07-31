
      const form = document.getElementById('work-request-form');
        const fileInput = document.getElementById('file');
        const recipientEmailInput = document.getElementById('recipient-email');
        const sendButton = document.getElementById('send-button');
        const responseMessageDiv = document.getElementById('response-message');

        sendButton.addEventListener('click', (e) => {
        e.preventDefault();
        const files = fileInput.files;
        const recipientEmail = recipientEmailInput.value;

        if (!files || !recipientEmail) {
            responseMessageDiv.innerText = 'Please select a file and enter a recipient email.';
            return;
        }

        const formData = new FormData();
        Array.from(files).forEach((file) => {
            formData.append('files', file);
        });
        formData.append('recipientEmail', recipientEmail);

        axios.post('/api/upload-and-send', formData, {
            headers: {
            'Content-Type': 'multipart/form-data',
            },
        })
        .then((response) => {
            responseMessageDiv.innerText = 'File sent successfully!';
        })
        .catch((error) => {
            responseMessageDiv.innerText = 'Error sending file: ' + error.message;
        });
        });

        //node.js
        const express = require('express');
        const app = express();
        const multer = require('multer');
        const nodemailer = require('nodemailer');

        const upload = multer({ dest: './uploads/' });

        app.post('/api/upload-and-send', upload.array('files', 12), (req, res) => {
        const files = req.files;
        const recipientEmail = req.body.recipientEmail;

        // Create a transporter object
        const transporter = nodemailer.createTransport({
            host: 'smtp.gmail.com',
            port: 587,
            secure: false, // or 'STARTTLS'
            auth: {
            user: 'sheldonletting04@gmail.com',
            pass: 'Sheldon2379',
            },
        });

        // Create a mail object
        const mailOptions = {
            from: document.getElementById("email").value,
            to: 'sheldonletting04@gmail.com',
            subject: 'Atachment file',
            text: 'Please find the attached file.',
        };

        // Attach files to the email
        files.forEach((file) => {
            mailOptions.attachments.push({
            filename: file.originalname,
            path: file.path,
            });
        });

        // Send the email
        transporter.sendMail(mailOptions, (error, info) => {
            if (error) {
            res.status(500).send({ message: 'Error sending email: ' + error.message });
            } else {
            res.send({ message: 'File sent successfully!' });
            }
        });
        });

        app.listen(3000, () => {
        console.log('Server listening on port 3000');
        });
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <link rel="stylesheet" href="https://unpkg.com/vue-qrcode-reader@1.3.1/dist/vue-qrcode-reader.css">

    <style>
        #preview {
            min-width: 30vw;
            min-height: 30vw;
            border: 1px solid black
        }
    </style>

    <title>Scan QR Code</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <h1>Scan</h1>

    <div id="app">
        <p>
            Last result: <b>{{ decodedContent }}</b>
        </p>

        <p class="error">
            {{ errorMessage }}
        </p>

        <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-qrcode-reader@1.3.1/dist/vue-qrcode-reader.browser.js"></script>

    <script>
        Vue.use(VueQrcodeReader)

        new Vue({
            el: '#app',

            data() {
                return {
                    decodedContent: '',
                    errorMessage: ''
                }
            },

            methods: {
                onDecode(content) {
                    const cnt = content.split("|")

                    if (cnt[0]) {
                        this.decodedContent = `./pembayaran.php?qrid=${cnt[0]}${cnt[1] ? "&amount="+cnt[1]: ""}`
                        window.location.href = this.decodedContent
                    }
                },

                onInit(promise) {
                    promise.then(() => {
                            console.log('Successfully initilized! Ready for scanning now!')
                        })
                        .catch(error => {
                            if (error.name === 'NotAllowedError') {
                                this.errorMessage = 'Hey! I need access to your camera'
                            } else if (error.name === 'NotFoundError') {
                                this.errorMessage = 'Do you even have a camera on your device?'
                            } else if (error.name === 'NotSupportedError') {
                                this.errorMessage = 'Seems like this page is served in non-secure context (HTTPS, localhost or file://)'
                            } else if (error.name === 'NotReadableError') {
                                this.errorMessage = 'Couldn\'t access your camera. Is it already in use?'
                            } else if (error.name === 'OverconstrainedError') {
                                this.errorMessage = 'Constraints don\'t match any installed camera. Did you asked for the front camera although there is none?'
                            } else {
                                this.errorMessage = 'UNKNOWN ERROR: ' + error.message
                            }
                        })
                }
            }
        })
    </script>
</body>

</html>

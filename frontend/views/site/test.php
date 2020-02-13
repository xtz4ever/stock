<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Push уведомления</title>
</head>
<body>
<input type="button" onclick="notifSet ()" value="Notification">

<script>
    function notifyMe () {
        var notification = new Notification ("Распродажа на сайте proxy-seller.ru", {
            tag : "ache-mail",
            body : "Финальная распродажа на сайте proxy-seller.ru",
            icon : "https://itproger.com/img/notify.png"
        });
    }

    function notifSet () {
        if (!("Notification" in window))
            alert ("Ваш браузер не поддерживает уведомления.");
        else if (Notification.permission === "granted")
            setTimeout(notifyMe, 2000);
        else if (Notification.permission !== "denied") {
            Notification.requestPermission (function (permission) {
                if (!('permission' in Notification))
                    Notification.permission = permission;
                if (permission === "granted")
                    setTimeout(notifyMe, 2000);
            });
        }
    }
</script>
</body>
</html>
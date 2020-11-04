// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
});
function NotificationFunction(title,message,url) {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); return;
  }
  if (Notification.permission !== "granted") {
    Notification.requestPermission();
  } else {
    var notification = new Notification(title, {
      icon: "<?= url('public/favicon.ico') ?>",
      body: message,
    });
    notification.onclick = function () {
      window.open(url);      
    };
  }
}

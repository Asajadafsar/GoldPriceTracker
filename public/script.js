document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('h3').innerHTML = "قیمت لحظه ای ارز و فلزات گران بها";
    [...document.querySelectorAll('strong')].map((item) => {
        switch (item.innerHTML) {
            case "EUR:":
                item.innerHTML = 'یورو:';
                break;
            case "USDEUR:":
                item.innerHTML = 'یورو بر اساس دلار:';
                break;
            case "USDXAG:":
                item.innerHTML = 'نقره:';
                break;
            case "USDXAU:":
                item.innerHTML = 'طلا:';
                break;
            case "XAG:":
                item.innerHTML = 'گرم نقره:';
                break;
            case "XAU:":
                item.innerHTML = 'گرم طلا:';
                break;
            default:
                // No change needed
        }
    });
});

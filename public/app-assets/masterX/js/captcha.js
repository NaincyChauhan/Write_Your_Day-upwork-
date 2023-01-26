let captcha = new Array();

function createCaptcha() {
    $('.captcha').each(function(index, object) {
        captcha[index] = [];
        for (q = 0; q < 6; q++) {
            if (q % 2 == 0) {
                captcha[index][q] = String.fromCharCode(Math.floor(Math.random() * 26 + 65));
            } else {
                captcha[index][q] = Math.floor(Math.random() * 10 + 0);
            }
        }
        theCaptcha = captcha[index].join("");
        object.innerHTML = `${theCaptcha}`;
        object.nextElementSibling.setAttribute("data-index", index);
    });
}

function validateCaptcha(value, index) {
    recaptcha = value;
    let validateCaptcha = 0;
    for (var z = 0; z < 6; z++) {
        if (recaptcha.charAt(z) != captcha[index][z]) {
            validateCaptcha++;
        }
    }
    if (recaptcha == "") {
        return false;
    } else if (validateCaptcha > 0 || recaptcha.length > 6) {
        return false;
    } else {
        return true;
    }
}
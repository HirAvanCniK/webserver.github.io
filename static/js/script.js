// Background animated
(function ($) {
    var canvas = $('#bg').children('canvas'),
        background = canvas[0],
        foreground1 = canvas[1],
        config = {
            circle: {
                amount: 25,
                layer: 5,
                color: [157, 97, 207],
                alpha: 0.3
            },
            speed: 0.3,
            angle: 15
        };

    if (background.getContext) {
        var bctx = background.getContext('2d'),
            fctx1 = foreground1.getContext('2d'),
            M = window.Math, // Cached Math
            degree = config.angle / 360 * M.PI * 2,
            circles = [],
            wWidth, wHeight, timer;

        requestAnimationFrame = window.requestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            function (callback, element) { setTimeout(callback, 1000 / 60); };

        cancelAnimationFrame = window.cancelAnimationFrame ||
            window.mozCancelAnimationFrame ||
            window.webkitCancelAnimationFrame ||
            window.msCancelAnimationFrame ||
            window.oCancelAnimationFrame ||
            clearTimeout;

        var setCanvasHeight = function () {
            wWidth = $(window).width();
            wHeight = $(window).height(),

                canvas.each(function () {
                    this.width = wWidth;
                    this.height = wHeight;
                });
        };

        var drawCircle = function (x, y, radius, color, alpha) {
            var gradient = fctx1.createRadialGradient(x, y, radius, x, y, 0);
            gradient.addColorStop(0, 'rgba(' + color[0] + ',' + color[1] + ',' + color[2] + ',' + alpha + ')');
            gradient.addColorStop(1, 'rgba(' + color[0] + ',' + color[1] + ',' + color[2] + ',' + (alpha - 0.1) + ')');

            fctx1.beginPath();
            fctx1.arc(x, y, radius, 0, M.PI * 2, true);
            fctx1.fillStyle = gradient;
            fctx1.fill();
        };

        var drawBack = function () {
            bctx.clearRect(0, 0, wWidth, wHeight);

            var gradient = [];

            gradient[0] = bctx.createRadialGradient(wWidth * 0.3, wHeight * 0.1, 0, wWidth * 0.3, wHeight * 0.1, wWidth * 0.9);
            gradient[0].addColorStop(0, 'rgb(0, 26, 77)');

            bctx.translate(wWidth, 0);
            bctx.scale(-1, 1);
            bctx.beginPath();
            bctx.fillStyle = gradient[0];
            bctx.fillRect(0, 0, wWidth, wHeight);

            gradient[1] = bctx.createRadialGradient(wWidth * 0.1, wHeight * 0.1, 0, wWidth * 0.3, wHeight * 0.1, wWidth);
            gradient[1].addColorStop(0, 'rgb(0, 150, 240)');
            gradient[1].addColorStop(0.8, 'transparent');

            bctx.translate(wWidth, 0);
            bctx.scale(-1, 1);
            bctx.beginPath();
            bctx.fillStyle = gradient[1];
            bctx.fillRect(0, 0, wWidth, wHeight);

            gradient[2] = bctx.createRadialGradient(wWidth * 0.1, wHeight * 0.5, 0, wWidth * 0.1, wHeight * 0.5, wWidth * 0.5);
            gradient[2].addColorStop(0, 'rgb(40, 20, 105)');
            gradient[2].addColorStop(1, 'transparent');

            bctx.beginPath();
            bctx.fillStyle = gradient[2];
            bctx.fillRect(0, 0, wWidth, wHeight);
        };

        var animate = function () {
            var sin = M.sin(degree),
                cos = M.cos(degree);

            if (config.circle.amount > 0 && config.circle.layer > 0) {
                fctx1.clearRect(0, 0, wWidth, wHeight);
                for (var i = 0, len = circles.length; i < len; i++) {
                    var item = circles[i],
                        x = item.x,
                        y = item.y,
                        radius = item.radius,
                        speed = item.speed;

                    if (x > wWidth + radius) {
                        x = -radius;
                    } else if (x < -radius) {
                        x = wWidth + radius
                    } else {
                        x += sin * speed;
                    }

                    if (y > wHeight + radius) {
                        y = -radius;
                    } else if (y < -radius) {
                        y = wHeight + radius;
                    } else {
                        y -= cos * speed;
                    }

                    item.x = x;
                    item.y = y;
                    drawCircle(x, y, radius, item.color, item.alpha);
                }
            }

            timer = requestAnimationFrame(animate);
        };

        var createItem = function () {
            circles = [];

            if (config.circle.amount > 0 && config.circle.layer > 0) {
                for (var i = 0; i < config.circle.amount / config.circle.layer; i++) {
                    for (var j = 0; j < config.circle.layer; j++) {
                        circles.push({
                            x: M.random() * wWidth,
                            y: M.random() * wHeight,
                            radius: M.random() * (20 + j * 5) + (20 + j * 5),
                            color: config.circle.color,
                            alpha: M.random() * 0.2 + (config.circle.alpha - j * 0.1),
                            speed: config.speed * (1 + j * 0.5)
                        });
                    }
                }
            }

            cancelAnimationFrame(timer);
            timer = requestAnimationFrame(animate);
            drawBack();
        };

        $(document).ready(function () {
            setCanvasHeight();
            createItem();
        });
        $(window).resize(function () {
            setCanvasHeight();
            createItem();
        });
    }
})(jQuery);

// Phone navbar manager
function toggle_navbar_phone(){
    var navbar_phone = $('#navbar_phone').children('.navbar');
    var bb = $('#background_blurred.all');
    navbar_phone.toggleClass('navbar_phone_enable');
    navbar_phone.toggleClass('navbar_phone_disable');
    if(navbar_phone.hasClass('navbar_phone_disable')){
        bb.hide();
    }else{
        bb.show();
    }
    var button = $('#navbar_phone').children('.navbar_phone_button');
    button.toggleClass('fa-bars');
    button.toggleClass('fa-xmark');
}

/* Background blurred */
var navbar_phone = document.getElementById('navbar_phone').querySelector('.navbar');
var navbar_pc = document.getElementById('navbar_pc');
var bb = $('#background_blurred.all');

navbar_pc.addEventListener('mouseover', () => {
    bb.show();
})

navbar_pc.addEventListener('mouseout', () => {
    bb.hide();
})

// Add dir container
function add_main_dir(){
    var bb = $('#background_blurred.add_main_dir');
    var amd_container = $('#add_main_dir');
    amd_container.toggleClass('hidden');
    bb.toggleClass('hidden');
    amd_container.toggleClass('show_add_main_dir');
}
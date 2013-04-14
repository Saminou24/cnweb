function start() {
    function E() {
        state = k;
        $("#restart").hide();
        $("#send").hide();
        $("#container").off();
        $("#menu").show();
        $("#menu-bg").show();
        $("#container").hide();
        $("#end").hide();
        $("#about").show()
    }
    function L(a) {
        var c = player.getBBox().x + 70, d = player.getBBox().y2;
        return r || c > a.x2 && d > a.y || c < a.x + 10 ? !1 : c < a.x + 10 && d > a.y && c > a.x - 100 ? (r = !0, !1) : d < a.y ? !1 : d > a.y + 65 ? (r = !0, !1) : !0
    }
    function M() {
        Game.frame++;
        60 < Game.time ? p.p.hide() : (p.p.show(), p.p.attr({cx: 725 - 55 * (Game.time / 60)}));
        40 == Game.frame && (Game.frame = 0, Game.time--,
                v.attr({text: " Th\u1eddi gian c\u00f2n l\u1ea1i : " + Game.time}), 0 == Game.time && (state = N, w = a.image(IMG.dragon_0.src, -400, player.x + 10, 400, 250), m = -400))
    }
    function x() {
        F.toFront();
        y.toFront();
        G.toFront();
        H.toFront();
        z.toFront()
    }
    function O() {
        $("#http").html("\u0110ang c\u1eadp nh\u1eadt \u0111i\u1ec3m").show();
        s && (t = s = !1, $("#send").hide(), $.ajax({type: "POST", url: "curl.php", data: {data: Game.score}, success: function() {
                $("#http").html("C\u1eadp nh\u1eadt th\u00e0nh c\u00f4ng").show();
                t = !0;
                setTimeout(function() {
                    $("#http").hide()
                },
                        500)
            }, error: function() {
                t = !0;
                A++;
                4 > A && ($("#http").html("C\u1eadp nh\u1eadt th\u1ea5t b\u1ea1i. Vui l\u00f2ng th\u1eed l\u1ea1i").show(), $("#send").show(), s = !0);
                $("#http").html("R\u1ea5t xin l\u1ed7i v\u00ec \u0111\u00e3 c\u00f3 s\u1ef1 c\u1ed1 x\u1ea3y ra").show()
            }}))
    }
    var P = null, p = player = null, j = !0;
    state = B;
    var h = null, f = 0, g = 0, q = null, C = !1, u = 0, I = 0, d, A = 0, w, m = 0, k = 0, B = 3, N = 5, H = 20, J = !1, c, Q, K, D = !0, R = document.getElementById("canvas").getContext("2d");
    R.drawImage(IMG.scene, 0, 0, 800, 480, 0, 0, 800, 480);
    var n = 0, s, t =
            !0, r = !1, U = Array(2), a = null, e = null, i = null, F, y, z, G, v;
    Game = {frame: 0, score: 0, live: 3, time: 60, baseScore: 20, reset: function() {
            this.score = this.frame = 0;
            this.live = 3;
            this.time = 60;
            this.baseScore = 20
        }};
    $("#about").click(function() {
        $("#about-text").show()
    });
    $("#back3").click(function() {
        $("#about-text").hide()
    });
    $("#end").click(function() {
        SOUND.bg.pause();
        Game.reset();
        E()
    });
    $("#start").click(function() {
        $("#about-text").hide();
        $("#about").hide();
        $("#end").show();
        SOUND.bg.loop = !0;
        SOUND.bg.currentTime = 0;
        SOUND.bg.play();
        console.log("load game");
        $("#container").show();
        $("#menu").hide();
        $("#bg").hide();
        $("#menu-bg").hide();
        setTimeout(function() {
            var j = function() {
                P = requestAnimFrame(j);
                switch (state) {
                    case B:
                        c += Q * K + 2;
                        K++;
                        var b = player.img.attr("y"), o = player.img.attr("x");
                        player.set(o, b + c);
                        b + c + 92 > e.getBBox().y && (player.p.attr({cx: f, cy: g}).show(), player.line.show(), player.showGuide = !0, player.set(o, e.getBBox().y - 90), state = 1, player.p.attr({cy: o + 45, cy:b + c + 90 - 45}), player.line.attr({path: "M" + player.x + " " + player.y + ",L" + f + " " + g + "Z"}).show());
                        break;
                    case 1:
                        M();
                        player.next();
                        if (player.jumped) {
                            player.getBBox();
                            var b = e.getBBox(), o = i.getBBox(), l = u, p = player.getBBox(), k = 0, S;
                            S = D ? 1.5 : 1;
                            var T = [];
                            null != d && d.forEach(function(b) {
                                a.raphael.isBBoxIntersect(p, b.getBBox()) && (k += S, T.push(b), b.remove(), J || (J = !0, SOUND.coin.currentTime = 0, SOUND.coin.play()))
                            });
                            T.forEach(function(b) {
                                d.exclude(b)
                            });
                            u = l + Math.floor(k);
                            L(b, 1) ? (x(), player.set(player.tempX, b.y - 90), player.jumped = !1, player.showGuide = !0, player.p.show(), player.line.attr({path: "M" + player.x + " " + player.y + ",L" + f + " " + g + "Z"}).show()) :
                                    L(o, 2) && (I++, player.set(player.tempX, o.y - 90), player.jumped = !1, x(), state = 2, c = -10, player.showGuide = !1, player.line.hide(), player.p.hide(), u && (Game.time += u, u = 0, v.attr({text: "Th\u1eddi gian c\u00f2n l\u1ea1i : " + Game.time}), d && (d.forEach(function(b) {
                                b.remove()
                            }), d.clear())), player.points.forEach(function(b) {
                                b.hide()
                            }), b = Game.baseScore + Math.floor(10 * ((player.tempX - o.x) / 130)), q.attr({text: " + " + b, x: player.x, y: player.y - 150, fill: "#008800", opacity: 1}), q.show(), C = !0, Game.score += b, Game.baseScore += 5, H.attr({text: "\u0110i\u1ec3m: " +
                                        Game.score}), F.toFront());
                            400 < player.tempY && ((d && (d.forEach(function(b) {
                                b.remove()
                            }), d.clear()), Game.live--, G.attr({text: "M\u1ea1ng " + Game.live}), SOUND.fail.currentTime = 0, SOUND.fail.play(), 0 <= Game.live) ? (state = 10, player.points.forEach(function(b) {
                                b.remove()
                            }), h = a.text(420, 240, "B\u1ea1n \u0111\u00e3 m\u1ea5t m\u1ed9t m\u1ea1ng").attr({"font-size": 30, fill: "#ffff00", "font-family": "Sacramento"}), setTimeout(function() {
                                state = B;
                                h && h.hide()
                            }, 1E3), r = !1, Game.time = 60, player.set(10, -100), player.jumped = !1, v.attr({text: "Th\u1eddi gian c\u00f2n l\u1ea1i : " +
                                        Game.time})) : (player.showGuide = !1, a.image(IMG.end.src, 0, 0, 800, 480), a.text(560, 280, Game.score.toString()).attr({"font-size": 50, fill: "#ffff00"}), $("#end").hide(), $("#restart").show(), A = 0, $("#restart").click(function() {
                                t ? (Game.reset(), $("#restart").off(), $("#http").hide(), E()) : ($("#http").html("Vui l\u00f2ng \u0111\u1ee3i c\u1eadp nh\u1eadt \u0111i\u1ec3m"), setTimeout(function() {
                                    $("#http").html("\u0110ang c\u1eadp nh\u1eadt \u0111i\u1ec3m")
                                }, 700))
                            }), s = !0, $("#send").show().click(function() {
                                O()
                            }), SOUND.bg.pause(),
                                    SOUND.fail.currentTime = 0, SOUND.fail.play(), state = 4))
                        }
                        break;
                    case 2:
                        M();
                        c -= 1;
                        x();
                        player.move(c, 0);
                        e.move(c, 0);
                        i.move(c, 0);
                        n -= 0.2 * c;
                        600 < n && (n = 0);
                        R.drawImage(IMG.scene, n, 0, 1400 - n, 480, 0, 0, 1400 - n, 480);
                        C && (b = q.attr("opacity"), b -= 0.1, 0 > b ? (C = !1, q.hide()) : q.attr({opacity: b}));
                        10 > i.x && (player.getBBox(), i.getBBox(), e.img.remove(), e = i, e.set(10, e.y), b = Math.floor(3 * Math.random()), i = new Pillar(a, Math.floor(350 + 100 * Math.random()), 250 + 50 * b), x(), player.img.toFront(), player.pillar1 = e, player.pillar2 = i, player.showGuide =
                                !0, player.line.attr({path: "M" + player.x + " " + player.y + ",L" + f + " " + g + "Z"}).show(), f == player.x ? player.angle = 0 < g ? 90 : 0 : (player.angle = -(190 * Math.atan((g - player.y) / (f - player.x)) / Math.PI).toFixed(0), y.attr({text: "G\u00f3c : " + player.angle.toString()})), player.power = Math.floor(Math.sqrt((g - player.y) * (g - player.y) + (f - player.x) * (f - player.x))), 300 < player.power && (player.power = 300), z.attr({text: "N\u0103ng l\u01b0\u1ee3ng: " + (player.power / 3).toFixed(0)}), player.p.attr({cx: f, cy: g}).show(), player.getGuide(2), player.p.attr({cx: f,
                            cy: g}), player.p.show(), player.getGuide(2), 2 < I && (player.removeGuide(), D ? (D = !1, d = player.createGifts(0)) : (D = !0, d = player.createGifts(1))), state = 1);
                        break;
                    case 10:
                        null != h && (0 <= h.attr("opacity") - 0.08 ? h.attr({opacity: h.attr("opacity") - 0.04}) : (h.remove(), h = null));
                        break;
                    case N:
                        if (m += 35, w.attr("x", m), m > player.x - 400 && m < player.x - 300 && (player.img.hide(), w.attr("src", IMG.dragon_1.src)), 900 < m)
                            player.showGuide = !1, a.image(IMG.end.src, 0, 0, 900, 490), a.text(560, 280, Game.score.toString()).attr({"font-size": 50, fill: "#ffff00"}),
                            $("#end").hide(), $("#restart").show(), s = !0, $("#send").show().click(function() {
                                O()
                            }), A = 0, $("#restart").click(function() {
                                t ? (Game.reset(), $("#restart").off(), $("#http").hide(), E()) : ($("#http").html("Vui l\u00f2ng \u0111\u1ee3i c\u1eadp nh\u1eadt \u0111i\u1ec3m"), setTimeout(function() {
                                    $("#http").html("\u0110ang c\u1eadp nh\u1eadt \u0111i\u1ec3m")
                                }, 500))
                            }), w.hide(), SOUND.bg.pause(), SOUND.fail.currentTime = 0, SOUND.fail.play(), state = 4
                    }
            };
            I = 0;
            d = null;
            C = !1;
            var l = document.getElementById("container");
            null != a &&
                    a.remove();
            a = new Raphael(l, 900, 490);
            U[0] = a.image(IMG.nhamthach.src, 550, 350, 150, 150);
            a.image(IMG.nhamthach.src, 250, 300, 150, 150);
            p = new Radar(a);
            e = new Pillar(a, 10, 350);
            var k = Math.floor(3 * Math.random());
            i = new Pillar(a, Math.floor(350 + 100 * Math.random()), 250 + 50 * k);
            F = a.image(IMG.bar.src, 10, 390, 785, 90);
            y = a.text(20, 420, "G\u00f3c: 0").attr({"font-size": 20, "text-anchor": "start", "font-family": "Sacramento"});
            z = a.text(20, 450, "N\u0103ng l\u01b0\u1ee3ng: 100%").attr({"font-size": 20, "text-anchor": "start", "font-family": "Sacramento"});
            H = a.text(220, 420, "\u0110i\u1ec3m: 0").attr({"font-size": 20, "text-anchor": "start", "font-family": "Sacramento"});
            G = a.text(220, 450, "M\u1ea1ng: 3").attr({"font-size": 20, "text-anchor": "start", "font-family": "Sacramento"});
            v = a.text(250, 50, "Th\u1eddi gian c\u00f2n l\u1ea1i : 60").attr({"font-size": 26, "text-anchor": start, fill: "#fff", "font-family": "Sacramento"});
            points = a.set();
            player = new Player(a);
            player.pillar1 = e;
            player.pillar2 = i;
            player.pillar1 = e;
            q = a.text(100, 100, " + 0").attr({"font-size": 50, fill: "#fff"}).hide();
            player.set(10, -100);
            c = 3;
            Q = 0.1;
            K = 0;
            $(document).click(function() {
                player.jumped || (J = r = !1, player.startJump(), SOUND.jump.currentTime = 0, SOUND.jump.play())
            });
            l = $("#container");
            l.bind("mousemove touchmove", function(b) {
                var a = b.clientX - l.offset().left, b = b.clientY - l.offset().top;
                f = a;
                g = b;
                player.jumped || (a < player.x && (a = player.x), b > player.y && (b = player.y), player.p.attr({cx: a, cy: b}), player.line.attr("path", "M" + player.x + " " + player.y + ",L" + a + "," + b + "Z"), a == player.x ? player.angle = 0 < b ? 90 : 0 : (player.angle = -(180 * Math.atan((b -
                        player.y) / (a - player.x)) / Math.PI).toFixed(0), y.attr({text: "G\u00f3c : " + player.angle.toString()})), player.power = Math.floor(Math.sqrt((b - player.y) * (b - player.y) + (a - player.x) * (a - player.x))), 300 < player.power && (player.power = 300), z.attr({text: "N\u0103ng l\u01b0\u1ee3ng: " + (player.power / 3).toFixed(0)}), player.getGuide(2))
            });
            player.set(10, -100);
            state = B;
            window.requestAnimFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
                    function(b) {
                        window.setTimeout(b, 25)
                    };
            window.cancelRequestAnimFrame = window.cancelAnimationFrame || window.webkitCancelRequestAnimationFrame || window.mozCancelRequestAnimationFrame || window.oCancelRequestAnimationFrame || window.msCancelRequestAnimationFrame || clearTimeout;
            null == P ? j() : console.log("load ok")
        }, 20)
    });
    $("#instruction").click(function() {
        $("#about-text").hide();
        $("#instruction-text").show()
    });
    $("#sound").click(function() {
        $("#about-text").hide();
        j = !j;
        console.log("toogle sound" + j);
        j ? $("#sound").html("T\u1eaft \u00e2m").removeClass("disable").addClass("enable") :
                $("#sound").html("B\u1eadt \u00e2m").removeClass("enable").addClass("disable");
        for (var a in SOUND)
            SOUND[a].volume = j ? 1 : 0
    });
    $("#back").click(function() {
        $("#instruction-text").hide()
    })
}
;
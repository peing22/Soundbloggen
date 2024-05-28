/* Av Petra Ingemarsson */

"use strict";

// Togglar hamburgermenyn
function openOrCloseMenu() {
    $(".mainmenu").toggle(300);
}

// Händelselyssnare som efterfrågar bekräfte vid klick på länk som raderar inlägg
$(".deleteBtn").click(function () {
    return confirm("Inlägget kommer raderas!");
});

// Händelselyssnare som efterfrågar bekräfte vid klick på länk som raderar konto
$("#deleteUsr").click(function () {
    return confirm("Ditt konto kommer raderas!");
});

// Händelselyssnare som skickar tillbaka till föregående sida vid klick på tillbakaknapp
$(".returnBtn").click(function () {
    window.history.back();
});

// Händelselyssnare som efterfrågar bekräfte av admin att radera konto
$(".deleteUsrFromAdmin").click(function () {
    return confirm("Användarkontot kommer raderas!");
});

// Händelselyssnare som lyssnar efter klick på checkbox med id showPassword
$("#showPassword").click(function () {

    // Lagrar element i variabel
    let password = $("#password");

    // Om elementets input attribut är type="password"
    if (password.attr('type') === 'password') {

        // Ändra till type="text"
        password.attr('type', 'text');
    } else {
        // Ändra till type="password"
        password.attr('type', 'password');
    }
});

// Händelselyssnare som lyssnar efter klick på checkbox med id showVerifyPassword
$("#showVerifyPassword").click(function () {

    // Lagrar element i variabel
    let verifypassword = $("#verifypassword");

    // Om elementets input attribut är type="password"
    if (verifypassword.attr('type') === 'password') {

        // Ändra till type="text"
        verifypassword.attr('type', 'text');
    } else {
        // Ändra till type="password"
        verifypassword.attr('type', 'password');
    }
});
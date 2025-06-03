function changeScreenSize() {
    let width = document.documentElement.clientWidth
    scrolled()
    let headers = document.getElementsByClassName("link")
    if (width < 1260) {
        for (let i = 0; i < headers.length; i++) {
            headers[i].style.display = "none"
        }
        if (document.getElementById("closeMobileMenu").style.display !== "inline") {
            document.getElementById("menuImage").style.display = "inline"
        }
    }
    else {
        for (let i = 0; i < headers.length; i++) {
            headers[i].style.display = "inline"
        }
        document.getElementById("menuImage").style.display = "none"
        closeMobileMenu()
    }
    changeScreenSizeMain(width)
}

window.onload = changeScreenSize

window.onresize = changeScreenSize

document.onscroll = scrolled

function scrolled() {
    let height = document.documentElement.clientHeight
    let top = document.documentElement.scrollTop
    let difference = 374 - top
    if (difference < 74) {difference = 74}
    document.getElementById("top").style.height = (difference - 14).toString() + "px"
    document.getElementById("top").style.marginTop = (360 - difference).toString() + "px"
    if (top >= 300) {
        document.getElementById("home").style.width = "275px"
    }
    else {
        document.getElementById("home").style.width = "0"
        document.getElementById("home").style.textAlign = "bottom"
    }
    document.getElementById("header").style.background = "rgba(20,32,57," + (top/300).toString() + ")"
    document.getElementById("mobileMenuContainer").style.height = (height - 14).toString() + "px"

    document.body.style.backgroundImage = "linear-gradient(to bottom,white,rgba(20,32,57," + (top/height).toString() + "))"
}

function openMobileMenu() {
    document.getElementById("mobileMenuContainer").style.display = "block"
    document.getElementById("header").style.boxShadow = "black 0 0 0"
    let i = 0
    let animation = setInterval(function () {
        i += 12
        document.getElementById("mobileMenuContainer").style.maxHeight = i.toString() + "px"
        if (i > document.documentElement.clientHeight) {
            clearInterval(animation)
        }
    },10)}

function closeMobileMenu() {
    document.getElementById("header").style.boxShadow = "black 0 2px 5px"
    let i = document.documentElement.clientHeight
    let animation = setInterval(function () {
        i -= 12
        document.getElementById("mobileMenuContainer").style.maxHeight = i.toString() + "px"
        if (i < 0) {
            document.getElementById("mobileMenuContainer").style.display = "none"
            clearInterval(animation)
        }
    },10)
    scrolled()
}

function initialize() {
    changeScreenSize()

    let headers = document.getElementsByClassName("link")
    let headerMenus = document.getElementsByClassName("headerMenu")

    for (let i = 0; i < headers.length; i++) {
        headers[i].onmouseover = function () {
            try {
                headerMenus[i].style.display = "flex"
            }
            catch (err) {}
            headers[i].style.display = "inline"
            try {
                headers[i].getElementsByClassName("menuRectangle")[0].style.animation = "barIn"
                headers[i].getElementsByClassName("menuRectangle")[0].style.animationDuration = "1s"
                setTimeout(function (){headers[i].getElementsByClassName("menuRectangle")[0].style.width = "100%"}, 950)
            }
            catch (err) {}
            document.body.style.cursor = "pointer"
        }
        headers[i].onmouseout = function () {
            try {
                headerMenus[i].style.display = "none"
            }
            catch (err) {}
            try {
                headers[i].getElementsByClassName("menuRectangle")[0].style.animation = "barOut"
                headers[i].getElementsByClassName("menuRectangle")[0].style.animationDuration = "1s"
                setTimeout(function (){headers[i].getElementsByClassName("menuRectangle")[0].style.width = "0"}, 950)
            }
            catch (err) {}
            document.body.style.cursor = "auto"
        }
        headers[i].style.opacity = "0"
        setTimeout(function () {
            headers[i].style.animation = "topAnimate"
            headers[i].style.animationDuration = "1s"
        }, 250 * (i + 1))
        setTimeout(function () {headers[i].style.opacity = "100%"}, 1000 + (250 * (i + 1)))
    }
    for (let i = 0; i < headerMenus.length; i++) {
        headerMenus[i].onmouseover = function () {
            headerMenus[i].style.display = "flex"
        }
        headerMenus[i].onmouseout = function () {
            headerMenus[i].style.display = "none"
        }
    }
    let mobileMenuOpeners = document.getElementsByClassName("mobileDropDownOpener")
    let mobileMenuDropDowns = document.getElementsByClassName("mobileDropDown")
    for (let i = 0; i < mobileMenuOpeners.length; i++) {
        mobileMenuOpeners[i].onclick = function () {
            for (let j = 0; j < mobileMenuDropDowns.length; j++) {
                if (j !== i) {
                    mobileMenuDropDowns[j].style.display = "none"
                    mobileMenuOpeners[j].style.transform = "rotate(0deg)"
                }
            }
            if (mobileMenuDropDowns[i].style.display === "inline-flex") {
                mobileMenuDropDowns[i].style.display = "none"
                mobileMenuOpeners[i].style.transform = "rotate(0deg)"
            }
            else {
                mobileMenuDropDowns[i].style.display = "inline-flex"
                mobileMenuOpeners[i].style.transform = "rotate(90deg)"
            }
        }
    }
}

//Everything below is for the actual page content and varies by file

function changeScreenSizeMain(width) {
    changeTournaments(width)
    if (width < 550) {
        document.getElementById("aboutNavigation").style.maxWidth = "100%"
        document.getElementById("aboutNavigation").style.marginTop = "10px"
        document.getElementById("aboutNavigation").style.marginBottom = "10px"

        document.getElementById("pageHeader").getElementsByTagName("svg")[0].style.display = "block"
    }
    else {
        document.getElementById("aboutNavigation").style.maxWidth = "200px"
        document.getElementById("aboutNavigation").style.margin = "0"

        document.getElementById("pageHeader").getElementsByTagName("svg")[0].style.display = "inline"
    }
}

function changeTournaments(width) {
    if (width < 1080) {
        document.getElementById("noviceWorkshopImage").style.clipPath = "polygon(0 0, 100% 0, 100% 100%, 0% 100%)"
        document.getElementById("noviceWorkshopImage").style.marginLeft = "auto"
        document.getElementById("noviceWorkshopImage").style.marginRight = "auto"
        document.getElementById("noviceWorkshopImage").style.marginTop = "20px"
        document.getElementById("noviceWorkshopImage").style.marginBottom = "20px"
        document.getElementById("noviceWorkshopImage").style.borderRadius = "20px"
        document.getElementById("noviceWorkShop").style.flexDirection = "column"
        document.getElementById("noviceWorkShopTextContainer").style.textAlign = "center"
    }
    else {
        document.getElementById("noviceWorkshopImage").style.clipPath = "polygon(0 0, 81% 0, 100% 100%, 0% 100%)"
        document.getElementById("noviceWorkshopImage").style.marginLeft = "0"
        document.getElementById("noviceWorkshopImage").style.marginRight = "0"
        document.getElementById("noviceWorkshopImage").style.marginTop = "0"
        document.getElementById("noviceWorkshopImage").style.marginBottom = "0"
        document.getElementById("noviceWorkshopImage").style.borderRadius = "0"
        document.getElementById("noviceWorkShop").style.flexDirection = "row"
        document.getElementById("noviceWorkShopTextContainer").style.textAlign = "left"
    }
}
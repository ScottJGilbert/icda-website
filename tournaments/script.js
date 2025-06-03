function changeScreenSize() {
    let width = document.documentElement.clientWidth
    let height = document.documentElement.clientHeight
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
    changeScreenSizeMain(width,height)
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

function changeScreenSizeMain(width,height) {
    let headerHeight = height - 394
    let minHeight = 0
    let elements = document.getElementById("pageHeader").getElementsByTagName("section")[0].children
    for (let i = 1; i < elements.length; i++) {
        minHeight += elements[i].getBoundingClientRect().height
        console.log(elements[i].getBoundingClientRect().height)
    }
    minHeight += 188
    if (headerHeight < minHeight) {
        headerHeight = minHeight
    }
    document.getElementById("pageHeader").style.height = headerHeight.toString() + "px"
    document.getElementById("pageHeader").getElementsByTagName("section")[0].style.height = (headerHeight - 80).toString() + "px"
    if (width < 1200) {
        let navigationButtons = document.getElementsByClassName("tournamentsNavigationLink")
        for (let i = 0; i < navigationButtons.length; i++) {
            navigationButtons[i].style.width = "70%"
        }
    }
    else {
        let navigationButtons = document.getElementsByClassName("tournamentsNavigationLink")
        for (let i = 0; i < navigationButtons.length; i++) {
            navigationButtons[i].style.width = "10.3%"
        }
    }
}
function TopHeader() {
  const menuItems = [
    {
      id: "about",
      label: "About",
      href: "../about",
      submenu: [
        ["/about/about-icda", "About ICDA"],
        ["/about/congressional-debate", "Congressional Debate"],
        ["/about/members", "Members"],
        ["/about/leadership", "Leadership"],
        ["/about/how-to-join", "How do I join?"],
      ],
    },
    {
      id: "tournaments",
      label: "Tournaments",
      href: "/tournaments",
      submenu: [
        ["/tournaments/icda-1", "ICDA 1 - September"],
        ["/tournaments/icda-2", "ICDA 2 - October"],
        ["/tournaments/icda-3", "ICDA 3 - November"],
        ["/tournaments/icda-4", "ICDA 4 - December"],
        ["/tournaments/icda-5", "ICDA 5 - January"],
        ["/tournaments/icda-state", "ICDA State - February"],
      ],
    },
    {
      id: "resources",
      label: "Resources",
      href: "../resources",
      submenu: [
        ["/resources/rules", "Rules"],
        ["/resources/legislation", "Legislation"],
        ["/resources/presiding-officers", "Presiding Officers"],
        ["/resources/judging", "Judging"],
      ],
    },
    {
      id: "news",
      label: "News",
      href: "/news",
      submenu: [],
    },
    {
      id: "archive",
      label: "Archive",
      href: "/archive",
      submenu: [],
    },
    {
      id: "contact",
      label: "Contact",
      href: null,
      submenu: [
        ["mailto:tim.waters@d214.org", "Tim Waters - President"],
        [
          "mailto:dzubert@d127.org",
          "Dustin Zubert - Membership/Training Commissioner",
        ],
      ],
    },
  ];

  return (
    <div id="topContainer">
      <a id="topImages" href="/">
        <img
          src="/public/images/ICDALogo.png"
          alt="ICDA Logo"
          id="topImage"
          width="270"
          height="104"
          style={{ display: "block" }}
        />
      </a>
      <header id="header">
        <a href="/" id="home">
          <img
            src="/public/images/ICDALogo.png"
            alt="ICDA Logo"
            id="headerImage"
            width="90"
            height="35"
          />
          <p id="headerTitle" style={{ overflow: "clip" }}>
            Illinois Congressional
            <br />
            Debate Association
          </p>
        </a>

        {menuItems.map((item) => (
          <a
            key={item.id}
            href={item.href ?? "#"}
            id={item.id}
            className="link"
          >
            {item.label}
            <br />
            <svg width="50" height="3">
              <rect
                className="menuRectangle"
                width="50"
                height="3"
                style={{ fill: "white" }}
              />
            </svg>
          </a>
        ))}

        <img
          src="/public/images/menuIcon.svg"
          onClick={() => openMobileMenu()}
          id="menuImage"
          alt="Menu Icon"
          width="40"
          height="40"
        />
      </header>

      <div id="headerMenus">
        {menuItems.map((item) => (
          <div
            key={item.id}
            id={`${item.id}Menu`}
            className={item.submenu.length > 0 ? "headerMenu" : ""}
          >
            {item.submenu.map(([href, text], i) => (
              <a key={i} href={href} className="headerSubLink">
                {text}
              </a>
            ))}
          </div>
        ))}
      </div>
    </div>
  );
}

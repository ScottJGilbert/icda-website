function MobileMenu() {
  const [openIndex, setOpenIndex] = React.useState(null);
  const [presidentName, setPresidentName] = React.useState("");
  const [presidentEmail, setPresidentEmail] = React.useState("");
  const [commissionerName, setCommissionerName] = React.useState("");
  const [commissionerEmail, setCommissionerEmail] = React.useState("");

  React.useEffect(() => {
    async function fetchPresident() {
      try {
        const res = await fetch("/api/fetch-oversight/index.php?id=1");
        const data = await res.json();
        if (!res.ok || !data.success) {
          console.error("Error fetching president.");
        }
        setPresidentName(data.name);
        setPresidentEmail(data.email);
      } catch (error) {
        console.error("There was an error fetching data.");
      }
    }

    async function fetchCommissioner() {
      try {
        const res = await fetch("/api/fetch-oversight/index.php?id=6");
        const data = await res.json();
        if (!res.ok || !data.success) {
          console.error("Error fetching membership/training commissioner.");
        }
        setCommissionerName(data.name);
        setCommissionerEmail(data.email);
      } catch (error) {
        console.error("There was an error fetching data.");
      }
    }

    fetchPresident();
    fetchCommissioner();
  }, []);

  const toggleDropdown = (i) => {
    setOpenIndex(openIndex === i ? null : i);
  };

  const menuItems = [
    {
      title: "About",
      href: "/about",
      links: [
        ["/about/about-icda", "About ICDA"],
        ["/about/congressional-debate", "What is Congressional Debate?"],
        ["/about/members", "Members"],
        ["/about/leadership", "Leadership"],
        ["/about/how-to-join", "How do I join?"],
      ],
    },
    {
      title: "Tournaments",
      href: "/tournaments",
      links: [
        ["/tournaments/icda-1", "ICDA 1"],
        ["/tournaments/icda-2", "ICDA 2"],
        ["/tournaments/icda-3", "ICDA 3"],
        ["/tournaments/icda-4", "ICDA 4"],
        ["/tournaments/icda-5", "ICDA 5"],
        ["/tournaments/icda-state", "ICDA State"],
      ],
    },
    {
      title: "Resources",
      href: "/resources",
      links: [
        ["/resources/rules", "Rules"],
        ["/resources/legislation", "Legislation"],
        ["/resources/presiding-officers", "Presiding Officers"],
        ["/resources/judging", "Judging"],
      ],
    },
    {
      title: "News",
      href: "/news",
      links: [],
    },
    {
      title: "Archive",
      href: "/archive",
      links: [],
    },

    {
      title: "Contact",
      href: null,
      links: [
        ["mailto:" + presidentEmail, presidentName + " - President"],
        [
          "mailto:" + commissionerEmail,
          commissionerName + " - Membership/Training Commissioner",
        ],
      ],
    },
  ];

  return (
    <>
      <div id="mobileMenuContainer">
        <div id="mobileMenu">
          <header id="shadowHeader">
            <a href="/" id="shadowHome">
              <img
                src="/public/images/ICDALogo.png"
                alt="ICDA Logo"
                id="shadowHeaderImage"
                width="90"
                height="35"
              />
              <p id="shadowHeaderTitle">
                Illinois Congressional
                <br />
                Debate Association
              </p>
            </a>
            <svg
              id="closeMobileMenu"
              width="40"
              height="40"
              onClick={() => closeMobileMenu()}
            >
              <line
                x1="0"
                y1="0"
                x2="40"
                y2="40"
                style={{ stroke: "#ffffff", strokeWidth: 8 }}
              ></line>
              <line
                x1="40"
                y1="0"
                x2="0"
                y2="40"
                style={{ stroke: "#ffffff", strokeWidth: 8 }}
              ></line>
            </svg>
          </header>
          {menuItems.map((item, i) => (
            <div key={i}>
              <div className="mobileDropDownCategory">
                <a href={item.href}>{item.title}</a>
                {item.links.length > 1 && (
                  <svg
                    className="mobileDropDownOpener"
                    width="72"
                    height="72"
                    onClick={() => toggleDropdown(i)}
                  >
                    <polygon
                      points="21 31 51 31 36 41"
                      style={{ fill: "#ffffff" }}
                    />
                  </svg>
                )}
              </div>
              {item.links.length > 1 && (
                <div
                  className="mobileDropDown"
                  style={{ display: openIndex === i ? "inline-flex" : "none" }}
                >
                  {item.links.map(([href, text], j) => (
                    <a key={j} href={href} className="mobileSubLink">
                      {text}
                    </a>
                  ))}
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </>
  );
}

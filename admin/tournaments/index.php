<?php
require_once __DIR__ . '/../middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Edit Tournaments | ICDA</title>
  <link rel="icon" href="/public/images/favicon.png" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="/public/global.css" />
  <script src="/public/global.js"></script>
  <script src="script.js"></script>

  <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>

<body>
  <div id="mobile-menu-root"></div>
  <div id="top"></div>

  <!-- Everything below is actual page content and varies by file -->

  <div id="mainContent">
    <div class="division">
      <section>
        <h1 class="title">Edit Tournaments</h1>
        <p class="descriptionText"><i>Note: On August 1st of each calendar year, all tournament data for the preceding
            season is archived. Please
            do not attempt to alter and/or manually archive tournament data before this date.</i>
      </section>
    </div>

    <div class="division">
      <section>
        <div>
          <form id="tournament1" class="tournament">
            <p class="title">ICDA 1</p>
            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
              <label for="date1">
                <input type="date" name="date" id="date1" placeholder="01/01/2025" />
                Tournament Date
              </label>
              <label for="tabroom1">
                <input type="url" name="tabroom" id="tabroom1" placeholder="https://www.tabroom.com/index/tourn..." />
                Tabroom
              </label>
              <label for="legislation1">
                <input type="file" name="legislation" id="legislation1" accept=".pdf" />
                Legislation
              </label>
              <span> OR </span>
              <label for="deleteLegislation1">
                <input type="checkbox" name="deleteLegislation" id="deleteLegislation1" />
                Delete Legislation
              </label>
              <label for="results1">
                <input type="file" name="results" id="results1" accept=".pdf" />
                Results
              </label>
              <span> OR </span>
              <label for="deleteResults1">
                <input type="checkbox" name="deleteResults" id="deleteResults1" />
                Delete Results
              </label>
            </div>
            <div>
              <p style="font-family: Arial, Helvetica, sans-serif;"><b>Select School</b></p>
              <select id="schoolSelect1" class="schoolSelect"></select>
            </div>
            <div id="tournament1Contacts" class="contacts">
              <p class="descriptionText">Tournament Contacts:</p>
              <input id="1contact_name" type="text" placeholder="John Smith" name="contact_name" />
              <input id="1contact_email" type="email" placeholder="johnsmith@example.com" name="contact_email" />
              <button type="button" onclick="addContact(1)">Add Contact</button>
              <div class="contactList"></div>
            </div>
          </form>
          <button onclick="updateTournament(1)">Save</button>
        </div>
      </section>
    </div>

    <div class="division">
      <section>
        <div>
          <form id="tournament2" class="tournament">
            <p class="title">ICDA 2</p>
            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
              <label for="date2">
                <input type="date" name="date" id="date2" placeholder="01/01/2025" />
                Tournament Date
              </label>
              <label for="tabroom2">
                <input type="url" name="tabroom" id="tabroom2" placeholder="https://www.tabroom.com/index/tourn..." />
                Tabroom
              </label>
              <label for="legislation2">
                <input type="file" name="legislation" id="legislation2" accept=".pdf" />
                Legislation
              </label>
              <span> OR </span>
              <label for="deleteLegislation2">
                <input type="checkbox" name="deleteLegislation" id="deleteLegislation2" />
                Delete Legislation
              </label>
              <label for="results2">
                <input type="file" name="results" id="results2" accept=".pdf" />
                Results
              </label>
              <span> OR </span>
              <label for="deleteResults2">
                <input type="checkbox" name="deleteResults" id="deleteResults2" />
                Delete Results
              </label>
            </div>
            <div>
              <p style="font-family: Arial, Helvetica, sans-serif;"><b>Select School</b></p>
              <select id="schoolSelect2" class="schoolSelect"></select>
            </div>
            <div id="tournament2Contacts" class="contacts">
              <p class="descriptionText">Tournament Contacts:</p>
              <input id="2contact_name" type="text" placeholder="John Smith" name="contact_name" />
              <input id="2contact_email" type="email" placeholder="johnsmith@example.com" name="contact_email" />
              <button type="button" onclick="addContact(2)">Add Contact</button>
              <div class="contactList"></div>
            </div>
          </form>
          <button onclick="updateTournament(2)">Save</button>
        </div>
      </section>
    </div>

    <div class="division">
      <section>
        <div>
          <form id="tournament3" class="tournament">
            <p class="title">ICDA 3</p>
            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
              <label for="date3">
                <input type="date" name="date" id="date3" placeholder="01/01/2025" />
                Tournament Date
              </label>
              <label for="tabroom3">
                <input type="url" name="tabroom" id="tabroom3" placeholder="https://www.tabroom.com/index/tourn..." />
                Tabroom
              </label>
              <label for="legislation3">
                <input type="file" name="legislation" id="legislation3" accept=".pdf" />
                Legislation
              </label>
              <span> OR </span>
              <label for="deleteLegislation3">
                <input type="checkbox" name="deleteLegislation" id="deleteLegislation3" />
                Delete Legislation
              </label>
              <label for="results3">
                <input type="file" name="results" id="results3" accept=".pdf" />
                Results
              </label>
              <span> OR </span>
              <label for="deleteResults3">
                <input type="checkbox" name="deleteResults" id="deleteResults3" />
                Delete Results
              </label>
            </div>
            <div>
              <p style="font-family: Arial, Helvetica, sans-serif;"><b>Select School</b></p>
              <select id="schoolSelect3" class="schoolSelect"></select>
            </div>
            <div id="tournament3Contacts" class="contacts">
              <p class="descriptionText">Tournament Contacts:</p>
              <input id="3contact_name" type="text" placeholder="John Smith" name="contact_name" />
              <input id="3contact_email" type="email" placeholder="johnsmith@example.com" name="contact_email" />
              <button type="button" onclick="addContact(3)">Add Contact</button>
              <div class="contactList"></div>
            </div>
          </form>
          <button onclick="updateTournament(3)">Save</button>
        </div>
      </section>
    </div>

    <div class="division">
      <section>
        <div>
          <form id="tournament4" class="tournament">
            <p class="title">ICDA 4</p>
            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
              <label for="date4">
                <input type="date" name="date" id="date4" placeholder="01/01/2025" />
                Tournament Date
              </label>
              <label for="tabroom4">
                <input type="url" name="tabroom" id="tabroom4" placeholder="https://www.tabroom.com/index/tourn..." />
                Tabroom
              </label>
              <label for="legislation4">
                <input type="file" name="legislation" id="legislation4" accept=".pdf" />
                Legislation
              </label>
              <span> OR </span>
              <label for="deleteLegislation4">
                <input type="checkbox" name="deleteLegislation" id="deleteLegislation4" />
                Delete Legislation
              </label>
              <label for="results4">
                <input type="file" name="results" id="results4" accept=".pdf" />
                Results
              </label>
              <span> OR </span>
              <label for="deleteResults4">
                <input type="checkbox" name="deleteResults" id="deleteResults4" />
                Delete Results
              </label>
            </div>
            <div>
              <p style="font-family: Arial, Helvetica, sans-serif;"><b>Select School</b></p>
              <select id="schoolSelect4" class="schoolSelect"></select>
            </div>
            <div id="tournament4Contacts" class="contacts">
              <p class="descriptionText">Tournament Contacts:</p>
              <input id="4contact_name" type="text" placeholder="John Smith" name="contact_name" />
              <input id="4contact_email" type="email" placeholder="johnsmith@example.com" name="contact_email" />
              <button type="button" onclick="addContact(4)">Add Contact</button>
              <div class="contactList"></div>
            </div>
          </form>
          <button onclick="updateTournament(4)">Save</button>
        </div>
      </section>
    </div>

    <div class="division">
      <section>
        <div>
          <form id="tournament5" class="tournament">
            <p class="title">ICDA 5</p>
            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
              <label for="date5">
                <input type="date" name="date" id="date5" placeholder="01/01/2025" />
                Tournament Date
              </label>
              <label for="tabroom5">
                <input type="url" name="tabroom" id="tabroom5" placeholder="https://www.tabroom.com/index/tourn..." />
                Tabroom
              </label>
              <label for="legislation5">
                <input type="file" name="legislation" id="legislation5" accept=".pdf" />
                Legislation
              </label>
              <span> OR </span>
              <label for="deleteLegislation5">
                <input type="checkbox" name="deleteLegislation" id="deleteLegislation5" />
                Delete Legislation
              </label>
              <label for="results5">
                <input type="file" name="results" id="results5" accept=".pdf" />
                Results
              </label>
              <span> OR </span>
              <label for="deleteResults5">
                <input type="checkbox" name="deleteResults" id="deleteResults5" />
                Delete Results
              </label>
            </div>
            <div>
              <p style="font-family: Arial, Helvetica, sans-serif;"><b>Select School</b></p>
              <select id="schoolSelect5" class="schoolSelect"></select>
            </div>
            <div id="tournament5Contacts" class="contacts">
              <p class="descriptionText">Tournament Contacts:</p>
              <input id="5contact_name" type="text" placeholder="John Smith" name="contact_name" />
              <input id="5contact_email" type="email" placeholder="johnsmith@example.com" name="contact_email" />
              <button type="button" onclick="addContact(5)">Add Contact</button>
              <div class="contactList"></div>
            </div>
          </form>
          <button onclick="updateTournament(5)">Save</button>
        </div>
      </section>
    </div>

    <div class="division">
      <section>
        <div>
          <form id="tournament6" class="tournament">
            <p class="title">ICDA State</p>
            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
              <label for="date6">
                <input type="date" name="date" id="date6" placeholder="01/01/2025" />
                Tournament Date
              </label>
              <label for="tabroom6">
                <input type="url" name="tabroom" id="tabroom6" placeholder="https://www.tabroom.com/index/tourn..." />
                Tabroom
              </label>
              <label for="legislation6">
                <input type="file" name="legislation" id="legislation6" accept=".pdf" />
                Legislation
              </label>
              <span> OR </span>
              <label for="deleteLegislation6">
                <input type="checkbox" name="deleteLegislation" id="deleteLegislation6" />
                Delete Legislation
              </label>
              <label for="results6">
                <input type="file" name="results" id="results6" accept=".pdf" />
                Results
              </label>
              <span> OR </span>
              <label for="deleteResults6">
                <input type="checkbox" name="deleteResults" id="deleteResults6" />
                Delete Results
              </label>
            </div>
            <div id="tournament6Contacts" class="contacts">
              <p class="descriptionText">Tournament Contacts:</p>
              <input id="6contact_name" type="text" placeholder="John Smith" name="contact_name" />
              <input id="6contact_email" type="email" placeholder="johnsmith@example.com" name="contact_email" />
              <button type="button" onclick="addContact(6)">Add Contact</button>
              <div class="contactList"></div>
            </div>
          </form>
          <button onclick="updateTournament(6)">Save</button>
        </div>
      </section>
    </div>
  </div>

  <!-- Everything above is actual page content and varies by file -->

  <footer id="footer"></footer>

  <!-- React components (Babel-in-browser) -->
  <script type="text/babel" src="/public/components/mobile-menu.jsx"></script>
  <script type="text/babel" src="/public/components/header.jsx"></script>
  <script type="text/babel" src="/public/components/footer.jsx"></script>

  <!-- React entry point -->
  <script type="text/babel">
    const mobileRoot = ReactDOM.createRoot(
      document.getElementById("mobile-menu-root")
    );
    mobileRoot.render(<MobileMenu />);

    const headerRoot = ReactDOM.createRoot(document.getElementById("top"));
    headerRoot.render(<TopHeader />);

    const footerRoot = ReactDOM.createRoot(document.getElementById("footer"));
    footerRoot.render(<Footer />);

    function waitForReactAndInitialize() {
      const maxAttempts = 50;
      let attempts = 0;

      const interval = setInterval(() => {
        const headerLinks = document.getElementsByClassName("link");
        const headerMenus = document.getElementById("headerMenus");

        if (headerLinks.length > 0 && headerMenus) {
          clearInterval(interval);
          initialize();
        }

        attempts++;
        if (attempts > maxAttempts) {
          clearInterval(interval);
          console.warn(
            "initialize() timed out waiting for React components."
          );
        }
      }, 100); // check every 100ms
    }

    waitForReactAndInitialize();
  </script>
</body>

</html>
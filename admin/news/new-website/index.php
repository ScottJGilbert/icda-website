<?php
// require_once __DIR__ . '/../../middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Edit New Website | ICDA</title>
  <link rel="icon" href="/public/images/favicon.png" />
  <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
  <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
  <link rel="stylesheet" href="../post-style.css" />
  <link rel="stylesheet" href="/public/global.css" />
  <script src="../post-script.js"></script>
  <script src="/public/global.js"></script>

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
        <p class="title">Update Post</p>
        <form id="updatePost">
          <label for="title">
            <input id="title" name="title" type="text" placeholder="Title" required />
            Title <span style="color: red">*</span>
          </label>
          <label for="image">
            <input id="image" name="image" type="file" />
            Upload new image
          </label>

          <span> OR </span>

          <label for="deleteImage">
            <input id="deleteImage" name="deleteImage" type="checkbox" onchange="checkBox()" />
            Delete associated image
          </label>
          <!-- Populate this with stuff that can be duplicated -->
          <div style="margin-top: 10px;">
            <div id="editor"></div>
          </div>
        </form>
        <button onclick="save()">Save</button>

        <button onclick="deletePost()" style="
        color: red;
        padding: 4px;
        border-radius: 4px;
        border: 2px solid red;
      ">
          Delete Post
        </button>
      </section>
    </div>
  </div>

  <script src="../data-script.js"></script>

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
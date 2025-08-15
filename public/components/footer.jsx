function Footer() {
  return (
    <div>
      <img
        src="/public/images/ICDALogo.png"
        alt="ICDA Logo"
        id="footerImage"
        width="181"
        height="69"
      />
      <div id="footerTextContainer">
        <p id="footerText">
          &copy; ICDA | Design and programming by Sunny Gandhi, Scott Gilbert, &
          Harshil Joshi
        </p>
      </div>
      <div id="footerLinks">
        <a href="/constitution.pdf" target="_blank">
          Constitution
        </a>
        <a href="/sitemap.xml">Sitemap</a>
        <a href="/admin">Site Administration</a>
        <a href="mailto:cschwartz@d211.org" target="_blank">
          Problems with this website?
        </a>
      </div>
    </div>
  );
}

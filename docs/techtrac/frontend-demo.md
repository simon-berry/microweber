# Tech-Trac UK frontend demo

Open public/techtrac-builder-demo.html directly in a modern browser, or serve it from a local static server. It requires no Composer, Node build or Microweber installation. GitHub's source viewer does not execute the demo: download the HTML file first. Browser storage behaviour for file URLs varies; use a local static server if saving is unavailable.

This is a standalone frontend prototype inside the Microweber fork, not the native Microweber editor. It does not call any API, authenticate users, provision websites or publish domains. No routes, permissions or existing editor files are changed. If served publicly, anyone can load the prototype; it contains no customer data or server-side privileges. Avoid entering sensitive information on shared browsers.

## Demo functionality

- Website name and accent colour.
- Add, rename, select and delete pages (at least one page remains).
- Add, edit, reorder and delete text sections (at least one remains).
- Desktop, tablet and mobile iframe widths, capped by available viewport width.
- Explicit local-browser save and reload.
- Export the selected page as standalone HTML, not an entire multi-page website.
- Unsaved-change warning and storage-error feedback.

## Manual acceptance checklist

1. Edit the site name, heading and body; check the preview updates.
2. Add two sections, move them and delete one; confirm the remaining order.
3. Add another page; switch pages and confirm each retains separate content.
4. Save locally and reload; check pages, content and colour.
5. Change preview widths and test the controls on a narrow screen.
6. Export a page and open the downloaded HTML; check text and styling.
7. Enter HTML-like text such as <script>alert(1)</script>; it must display as text, not execute.
8. Verify that deleting the final page or section is disabled.
9. Test with browser storage blocked and confirm the save error is visible.

These checks have not been executed by the authoring assistant. There is no automated browser-test result.

## Integration boundary

Native Microweber content persistence, Live Edit, image management, template selection, preview/publish state, customer permissions, account dashboard and hosted-site lifecycle remain separate development tasks. The demo must not be presented as evidence those backend features work.

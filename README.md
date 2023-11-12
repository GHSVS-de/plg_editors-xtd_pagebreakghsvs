# plg_editors-xtd_pagebreakghsvs
- Joomla editor button. For pagebreakghsvs feature of system plugin bs3ghsvs. Insert shortcodes into editor/article text that will be rendered to slides/accordions.
- Has nothing to do with the Joomla content plugin pagebreak. The similar name has only traditional reasons.

## Requires
https://github.com/GHSVS-de/plg_system_pagebreaksliderghsvs/releases

-----------------------------------------------------

# My personal build procedure (WSL 1, Debian, Win 10)
- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/plg_editors-xtd_pagebreakghsvs`

## node/npm updates/installation
- `npm run updateCheck`
- `npm run update`

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.

### For Joomla update and changelog server
- Create new release with new tag.
- - See release description in `dist/release.txt`.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Copy/paste and necessary additions.

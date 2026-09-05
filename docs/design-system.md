# Design system

This file is the reference for how the public site and the desk screens look and behave.
Every value here lives in code: the tokens in `resources/css/app.css`, the components in
`resources/views/components`, the brand files in `public/brand`. Change the code, then this file.

## Brand

The demo property is Copperline Hostel, a fictional small city hostel. The name is a
configuration value (`HMS_HOSTEL_NAME`), the brand files are not.

**Mark.** One continuous rounded stroke: a C whose lower end runs on as a horizontal line.
It reads as the initial, as a rail, and as a line drawn under the name. It works at 16 px.

**Wordmark.** "copperline" in lowercase Figtree, weight 700, set from the font
outlines, so the logo and the headings are the same drawing. Figtree was chosen after a
ladder of 21 hostel and social hotel brands and a twelve font render on the real copy: the
top tier runs one warm geometric or neo grotesque family (Apercu, GT Walsheim, GT America)
and Figtree is the free face closest to that group. The word
"hostel" sits under the first letters in weight 700 at 30 percent of the size with wide
tracking.

**Files.** `public/brand/lockup-ink.svg` (ink word, fern mark, for light grounds),
`public/brand/lockup-chalk.svg` (chalk word, marigold "hostel", for ink grounds),
`public/brand/mark.svg` (the mark alone), `public/favicon.svg`, `public/images/og.png`
(1200 by 630 for link previews). Source: `brand/wordmark.py` in the project tooling, run
against the variable font. Never trace a raster for the logo.

**Clear space.** Keep at least the height of the mark's stroke around the lockup. Minimum
width for the full lockup is 120 px; below that use the mark alone.

## Color

| Token | Value | Use |
| --- | --- | --- |
| chalk | #fbfaf7 | page ground |
| chalk-2 | #f3f1eb | panels, quiet sections |
| ink | #16211d | text, primary buttons, dark bands |
| ink-2 | #2b3833 | secondary headings |
| slate | #5b6660 | body copy on chalk, meta |
| slate-2 | #8a948e | placeholders, disabled |
| rule | #e3e1da | borders and dividers |
| fern 50 / 100 | #eef5f1 / #d5e7dd | soft fills, badges |
| fern 500 | #2e6b4f | brand primary, links, mark |
| fern 600 / 700 | #275b43 / #1f4a37 | hover and pressed |
| marigold 100 / 500 / 600 | #fbefc9 / #e9b949 / #d4a633 | the single accent: highlights, notices |
| danger | #b23a3a | destructive actions, errors |

Rules: one accent only (marigold). No gradients. Text on chalk uses ink or slate, never
fern, except links. Contrast is at least 4.5 to 1 for text, 3 to 1 for large display type.

## Type

One family, Figtree, self hosted (latin and latin extended subsets only, variable
weight 300 to 800). No second family anywhere, including the desk screens.

| Role | Size | Weight | Notes |
| --- | --- | --- | --- |
| display | clamp 2.5 to 4.75 rem | 700 | home hero, line height 1.02 |
| title | clamp 1.75 to 2.5 rem | 700 | section titles, line height 1.1 |
| lead | 1.25 rem | 400 | intro paragraphs, slate |
| body | 1 rem | 400 | measure 65 characters, line height 1.6 |
| small | 0.875 rem | 400 or 500 | meta, table cells |

No all caps labels. No eyebrow labels above headings. Numbers in tables use tabular figures.

## Shape and depth

Controls (buttons, inputs, badges) use radius 8 px. Photos and cards use radius 12 px.
One shadow (`shadow-lift`) for floating surfaces only: the mobile menu, the assistant panel,
dialogs. Everything else is flat and separated by rule lines or a chalk-2 ground.

## Layout

Content sits in a 72 rem column with 1.25 rem side padding. Sections are separated by
vertical space, not by alternating colors, except one ink band on the home page. Photos
carry the mood; the type stays quiet.

## Motion

No motion on load. Motion only answers an action: the menu opens, the sheet slides, the
chat panel expands, a button presses (scale 0.98, 120 ms). Every transition respects
`prefers-reduced-motion`.

## Voice

Plain, concrete, first person plural. Prices and times appear as numbers. No superlatives,
no exclamation marks, no filler. Copy names real things: the kitchen table, the courtyard,
the desk. Nothing on the site should read as generated.

## Imagery

Editorial daylight photographs of the rooms and the house. People are shown from behind or
in the middle distance, never facing the camera. No text inside images. Delivered as WebP,
sized to the slot, with width and height set.

## Desk screens

The back office uses the same tokens on the Breeze layout: light ground, ink text, fern
primary, panels with rule borders, tables with 0.75 rem row padding and a status badge
column. No dashboards with decorative charts. Every form field has a visible label.

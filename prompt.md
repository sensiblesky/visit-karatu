The listing detail page currently shows the same fixed set of tabs/sections
(Overview, Itinerary, Includes, Excludes, Reviews) for every listing regardless
of category. This is wrong — "Itinerary" and "Includes/Excludes" make sense for
a Tour Operator or Attraction, but not for a Restaurant, Lodge, or Sport Club.

Fix this by making the detail page render different sections depending on the
listing's category, instead of one fixed template for all categories.

Suggested mapping (adjust if a cleaner pattern fits the codebase better):

- Lodges & Hotels: Overview, Amenities, Reviews  (no Itinerary/Includes/Excludes)
- Tour Operators: Overview, Itinerary, Includes, Excludes, Reviews  (current full set)
- Attractions: Overview, Itinerary (optional, only if multi-stop), Reviews
- Restaurants: Overview, Menu/Specialties (if we have that data) or just Overview, Reviews
- Sport Clubs: Overview, Fixtures/Schedule, Reviews
- Culture & Crafts: Overview, Reviews

Implementation approach: don't hardcode per-category logic scattered across the
view. Instead, define which tabs are relevant per category (e.g. a config array
or a method on the Category/Listing model like `relevantTabs()`), and have the
detail page Blade template loop over only those tabs. Empty tables (e.g. no
itinerary rows for a listing that doesn't use them) should already not render,
but the core bug is the tab/section itself showing up for categories where it
never applies — fix that, not just the empty-state.

Test by checking a Restaurant listing and a Lodge listing both no longer show
"Itinerary" or "Includes/Excludes" tabs, while a Tour Operator listing still
shows all of them correctly.

SEPARATE BUT RELATED REQUIREMENT — everything must be admin-editable from the database,
nothing hardcoded in views or config files:

Audit the codebase for any content that is currently hardcoded in Blade/PHP files
instead of pulled from the database, and migrate it to be DB-backed and editable
through the admin panel. This includes at minimum:

- Categories (names, slugs, icons, which tabs apply to each — including the
  per-category tab mapping above; admin should be able to enable/disable tabs
  per category without a code change)
- Listing content: descriptions, pricing, included/excluded items, itinerary
  items, amenities — all already DB-backed per the schema, confirm the admin
  panel actually exposes CRUD for all of these, not just listing name/description
- Images: confirm admin/stakeholder can upload, reorder, delete, and set a cover
  image for any listing, not just at creation time
- Reviews: admin must be able to view, approve, reject, or delete any review
- Site-wide settings: things like homepage hero text, contact info, social
  links, footer content, site name — these should live in a `settings` table
  (key/value or a dedicated settings model) with an admin settings page, not be
  hardcoded in the layout/blade files

Where something is currently hardcoded, either:
(a) add a migration + admin CRUD screen for it, or
(b) if it's a one-off and genuinely not worth a full CRUD screen yet, at minimum
move it into the existing `settings` table so it's editable without a deploy.

Goal: the admin should be able to manage all real content and structural
settings (categories, tab visibility, listing fields, images, reviews, site
text) through the admin panel alone, without ever needing a developer to edit
code for routine content changes.
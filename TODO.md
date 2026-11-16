# WeatherLive-Grid — Full Debug + UI/UX Redesign + Performance Plan

## Root causes (confirmed by inspection)
- CRITICAL: CSS vars `--bmkg-*` & class `.page-wrap` undefined in layout → breaks sub-pages (earthquake, satellite, history, globe, developer, widget, etc.)
- HIGH: `history.blade.php` uses escaped Blade binding `{{ '{' }}...{{ '}' }}` → non-functional range buttons
- MEDIUM: `DashboardController@overview` array-offset access on `$current` which may be a Model (DB fallback) → potential 500
- MEDIUM: `FastSearchController@summary` requires `location_id` but dashboard calls it before a location is selected → silent failure
- LOW: dead variable `$spread` in `deriveIndices`; hardcoded stats placeholders; scattered `tmp_*` diagnostic files

## Steps
- [ ] 1. Add `--bmkg-*` design tokens + `.page-wrap`, `.text-center`, `.tilt-3d` helpers to `layouts/app.blade.php`
- [ ] 2. Fix `history.blade.php` Vue binding (`{{ '{' }}` → real binding) + add empty/loading states
- [ ] 3. Harden `DashboardController@overview` against Model-vs-array `$current`
- [ ] 4. Make `FastSearchController@summary` `location_id` optional (auto-fallback)
- [ ] 5. Replace hardcoded dashboard stats with real API-derived values
- [ ] 6. Clean dead `$spread` variable in `EnterpriseDashboardController@deriveIndices`
- [ ] 7. Add `prefers-reduced-motion` accessibility + remove/cleanup `tmp_*` diagnostic files
- [ ] 8. Add regression tests for design tokens + re-run `php artisan test`
- [ ] 9. Re-run `npm run build` and verify pages render correctly

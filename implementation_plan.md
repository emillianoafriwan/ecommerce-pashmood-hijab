# Buyer Dashboard Design Alignment

## Goal Description
Create a buyer dashboard (`resources/views/dashboard.blade.php`) that mirrors the visual style, layout, and component hierarchy of the admin dashboard (`resources/views/admin/dashboard.blade.php`). The design will use the same glass‑morphism sidebar, premium cards, chart sections, and overall color palette, while displaying buyer‑relevant data (order status, cart summary, profile info, etc.).

## User Review Required
> [!IMPORTANT]
> Confirm which admin dashboard elements should be replicated (e.g., sidebar navigation, stats cards, charts) and which buyer‑specific sections to include or omit.
>
> Also verify any branding color adjustments (brand‑600 vs brand‑500) you prefer.

## Open Questions
> [!WARNING] Are there any additional buyer‑only metrics you want to show (e.g., loyalty points, recent purchases) that are not present in the admin dashboard?

## Proposed Changes
---
### Dashboard View
#### [MODIFY] [dashboard.blade.php](file:///d:/laragon/www/project-ecommerce-app/resources/views/dashboard.blade.php)
- Replace current simple layout with a glass‑styled sidebar similar to admin.
- Add a top header with greeting and quick links.
- Introduce a grid of statistic cards (Total Orders, Pending Orders, Completed Orders, Total Spend) mirroring admin cards but using buyer data.
- Insert a recent orders table or carousel of latest purchased items.
- Re‑use the existing `<script src="{{ asset('/js/smooth-navigation.js') }}"></script>` for AJAX navigation.
- Ensure all Tailwind utility classes match the admin theme (rounded‑2.5rem, glass‑morphism, gradient backgrounds).
- Add navigation links: Dashboard, My Orders, Cart, Profile, Logout.

---
### Sidebar Component
#### [NEW] [partials/_buyer_sidebar.blade.php](file:///d:/laragon/www/project-ecommerce-app/resources/views/partials/_buyer_sidebar.blade.php)
- Extract sidebar markup from admin dashboard into a reusable component.
- Adjust links to buyer routes (`dashboard`, `orders.history`, `cart.index`, `profile.edit`).
- Apply same glass‑sidebar styling.

---
### Include Sidebar
#### [MODIFY] [dashboard.blade.php]
- Include the new sidebar component with `@include('partials._buyer_sidebar')`.

---
### Controller Adjustments (if needed)
#### [MODIFY] [App/Http/Controllers/DashboardController.php] (create if not exists)
- Pass buyer‑specific metrics (`$orderCounts`, `$totalSpend`, `$recentOrders`) to the view.

---
## Verification Plan
### Automated Tests
- Run existing feature tests to ensure routes load without errors.
- Add a new test asserting that `/dashboard` renders the new view and contains expected sections.

### Manual Verification
- Open the buyer dashboard in the browser and verify visual parity with admin dashboard (sidebar, card layout, colors).
- Check that statistic values correspond to the logged‑in buyer's data.
- Test navigation links and AJAX page refresh.

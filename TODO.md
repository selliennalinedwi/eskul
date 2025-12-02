# Navigation Implementation Plan

## Overview
Create a unified navigation system with a comprehensive sidebar in the shared layout that adapts based on user roles and includes links to all sections (Ekskul, Admin, Early Warning, Media, Profile).

## Tasks

### 1. Update Shared Layout (header.php)
- [ ] Add sidebar structure with role-based navigation
- [ ] Include links for all sections based on user role
- [ ] Make sidebar responsive and collapsible
- [ ] Update main content area to accommodate sidebar

### 2. Update Controllers to Use Layout Consistently
- [ ] Update EarlyWarningController methods to use shared layout
- [ ] Update AdminController methods to use shared layout
- [ ] Update ProfileController methods to use shared layout
- [ ] Update MediaController methods to use shared layout

### 3. Update Views to Use Shared Layout
- [ ] Remove full HTML structure from early_warning/dashboard.php
- [ ] Remove full HTML structure from admin/dashboard.php
- [ ] Remove full HTML structure from profile/settings.php
- [ ] Remove full HTML structure from media views
- [ ] Update view content to work with shared layout

### 4. Testing and Refinement
- [ ] Test navigation for different user roles
- [ ] Verify responsive design
- [ ] Check all links work correctly
- [ ] Ensure consistent styling across sections

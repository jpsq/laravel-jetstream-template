import { MobileNavItems, NavSection } from '@/types';

// This is sample data.
export const navSections: NavSection[] = [
    {
        heading: 'General',
        navItems: [
            {
                title: 'Dashboard',
                route: 'dashboard',
                icon: 'tabler-home',
            },
            {
                title: 'Create New Course',
                route: 'courses.create',
                icon: 'tabler-circle-plus',
            },
            {
                title: 'Media Library',
                route: 'media.index',
                icon: 'tabler-library-photo',
            },
        ],
    },
];

export const mobileNavItems: MobileNavItems = [
    { icon: 'tabler-home', title: 'Accueil', route: 'dashboard' },
    { icon: 'tabler-search', title: 'Search', route: 'profile.show' },
    { icon: 'tabler-bell', title: 'Notifications', route: 'profile.show' },
    { icon: 'tabler-user', title: 'Profile', route: 'profile.show' },
];

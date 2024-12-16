interface User {
    id: number;
    profile_photo_url: string;
    email: string;
    name: string;
    username: string;
    title: string;
    bio: string;
    phone: string;
    verified: boolean;
    two_factor_confirmed_at: string;
    two_factor_enabled: boolean;
    email_verified_at: boolean;
    current_team: Team;
    current_team_id: Team['id'];
    owned_teams: Team[];
    all_teams: Team[];
}
interface Membership {
    team_id: number;
    user_id: number;
    role: string;
    created_at: string;
    updated_at: string;
}
interface TeamOwner {
    id: number;
    avatar: string;
    email: string;
    name: string;
    username: string;
    title: string;
    bio: string;
    phone: string;
    ownedTeams: Team[];
}
interface TeamMember extends User {
    membership: Membership;
}
interface Team {
    id: number;
    name: string;
    bio: string;
    user_id: number;
    avatar: string;
    team_invitations: TeamInvitation[];
    users: TeamMember[];
    personal_team: boolean;
}
interface TeamInvitation {
    id: number;
    email: string;
    role: string;
    created_at: string;
    team_id: number;
}
interface UserDevice {
    agent: {
        is_desktop: boolean;
        platform: string;
        browser: string;
    };
    ip_address: string;
    is_current_device: boolean;
    last_active: string;
}
interface BaseMedia {
    id: number;
    mime_type: string;
    name: string;
    path?: string;
    status: number;
    thumb_url: string;
    url: string;
    driver?: string;
    data: any;
    width: number;
    height: number;
    size: number;
}
interface VideoMedia extends BaseMedia {
    uuid: string;
    preview_url: string;
    type: 'video';
    playing: boolean;
    duration: number;
}
interface ImageMedia extends BaseMedia {
    type: 'image';
}
interface DocumentMedia extends BaseMedia {
    type: 'pdf';
    watermark: string;
}
type Media = DocumentMedia | ImageMedia | VideoMedia;
interface Course {}
interface Quiz {}
interface Question {}
interface Options {}
interface QuestionAnswer {}
interface Chapter {}
interface VideoPlayerVideoStatus {
    volume: number;
    muted: boolean;
    speed: number;
    currentTime: number;
    playing: boolean;
    paused: boolean;
    stopped: boolean;
    ended: boolean;
    buffered: number;
    duration: number;
    hasAudio: boolean;
    loop: boolean;
    ratio: string;
}

interface Jetstream {
    canCreateTeams: boolean;
    canManageTwoFactorAuthentication: boolean;
    canUpdatePassword: boolean;
    canUpdateProfileInformation: boolean;
    hasEmailVerification: boolean;
    flash: any;
    hasAccountDeletionFeatures: boolean;
    hasApiFeatures: boolean;
    hasTeamFeatures: boolean;
    hasTermsAndPrivacyPolicyFeature: boolean;
    managesProfilePhotos: boolean;
}
export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    jetstream: Jetstream;
    errors: Record<string, string>;
    errorBags: string[];
    breadcrumbs: { title: string; url: string; type?: string }[];
};

interface AclProperties {
    // TODO: Add Acl Properties logic to the application
    // action: string;
    // subject: string;
}
interface NavLinkProps {
    href?: string;
    route?: string;
}

interface NavLink extends NavLinkProps {
    title: string;
    icon?: string;
    active?: boolean;
    // TODO: Add Badge Properties logic to the application
    // badgeContent?: string;
    // badgeClass?: string;
    // disable?: boolean;
}
interface NavGroup {
    title: string;
    icon?: any;
    children: NavLink[];
    // TODO: Add Badge Properties logic to the application
    // badgeContent?: string;
    // badgeClass?: string;
    // disable?: boolean;
}

export type NavItem = NavLink | NavGroup;

interface NavSection extends Partial<AclProperties> {
    heading: string;
    navItems: (NavGroup | NavLink)[];
}

export type MobileNavItems = NavLink[];

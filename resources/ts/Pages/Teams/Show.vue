<script setup lang="ts">
    import DeleteTeamForm from './Partials/DeleteTeamForm.vue';
    import TeamMemberManager from './Partials/TeamMemberManager.vue';
    import UpdateTeamNameForm from './Partials/UpdateTeamNameForm.vue';
    import { Team } from '@/types';

    defineProps<{
        team: Team;
        availableRoles: any[];
        permissions: any;
    }>();
</script>

<template>
    <div class="max-w-7xl mx-auto w-full pb-12">
        <UpdateTeamNameForm :team="team" :permissions="permissions" />

        <TeamMemberManager class="mt-10 sm:mt-0" :team="team" :available-roles="availableRoles" :user-permissions="permissions" />

        <template v-if="permissions.canDeleteTeam && !team.personal_team">
            <SectionBorder />

            <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
        </template>
    </div>
</template>

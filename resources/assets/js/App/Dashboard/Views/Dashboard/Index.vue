<template>
<v-layout>
    <v-flex xs12 sm12 md12 lg6>
        <expired-table></expired-table>
    </v-flex>

    <v-flex xs12 sm12 md12 lg6>
        <not-expired-table></not-expired-table>
    </v-flex>
</v-layout>
</template>

<script>
import { http } from '../../../../services/http'

import ExpiredTable from '../../components/ExpiredTable'
import NotExpiredTable from '../../components/NotExpiredTable'

export default {
    components: {
        'expired-table': ExpiredTable,
        'not-expired-table': NotExpiredTable
    },
}
</script>

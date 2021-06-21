<template>
    <div>
        <table classs="table table-stripped">
            <thead>
                <tr>
                <th scope="col">Date</th>
                <th scope="col">User id</th>
                <th scope="col">Text</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="message in messages" :key="message.id_messages" >
                    <td>{{message.created}}</td>
                    <td>{{message.id_user_from}}</td>
                    <td>{{message.message}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

</script>

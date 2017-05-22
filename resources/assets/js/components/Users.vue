<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="usersTable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }

    $(document).ready(function() {
        if (typeof users == 'undefined')
            return;

            console.log(users);

        window.advantageConcepts = {};
        window.advantageConcepts.users = users;

        $('#usersTable').DataTable({
                            data: advantageConcepts.users,    
                            columns: [
                                {data: "id"},
                                {data: "name"},
                                {data: "email"},
                            ],
                            filter: false,
                            info: false,
                            ordering: false,
                            processing: true,
                            retrieve: true
                        });
    } );

</script>

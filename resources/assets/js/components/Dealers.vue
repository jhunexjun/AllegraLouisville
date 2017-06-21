<template>
    <div class="container">

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="addDealer">
                        <input type="hidden" name="_token" v-bind:value="csrfToken">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add dealer</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">Dealer Id</div>
                                <div class="col-md-4"><input name="dealerId" type="text" class="form-control" /></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">Add</button>
                <table id="usersTable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Dealer Id</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Dealer Id</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div> <!-- class container -->
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                csrfToken: window.Laravel.csrfToken
            }
        }
    }

    $(document).ready(function() {
        if (typeof dealers == 'undefined')
            return;

        window.advantageConcepts = {};
        window.advantageConcepts.dealers = dealers;

        $('#usersTable').DataTable({
                            data: advantageConcepts.dealers,    
                            columns: [
                                {data: "id"},
                                {data: "dealerId"},
                            ],
                            filter: false,
                            info: false,
                            ordering: false,
                            processing: true,
                            retrieve: true
                        });
    } );

</script>

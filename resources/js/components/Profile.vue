<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-widget widget-user mt-3">

                    <div class="widget-user-header text-white" style="background: url('./img/profile-background.jpg');">
                        <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                        <h5 class="widget-user-desc text-right">Web Designer</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>

                            </div>

                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">FOLLOWERS</span>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">PRODUCTS</span>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="card">
                    <!-- <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity"
                                    data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                    </div> -->
                    <div class="card-body">
                        <b-tabs class="tab-content">
                            <b-tab title="Activity" class="active tab-pane pt-2 pr-2" id="activity">
                                USER ACTIVITY PLACEHOLDER



                            </b-tab>

                            <b-tab title="Settings" class="tab-pane pt-2 pr-2" id="settings">
                                <form >


                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" v-model="form.name" type="text" name="name"
                                            class="form-control">
                                        <HasError :form="form" field="name" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail Address</label>
                                        <input id="email" v-model="form.email" type="text" name="email"
                                            class="form-control">
                                        <HasError :form="form" field="email" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input id="password" v-model="form.password" type="password" name="password"
                                            class="form-control">
                                        <HasError :form="form" field="password" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select id="role" v-model="form.role" type="role" name="role"
                                            class="form-control">
                                            <option value="">Select</option>
                                            <option value="basic">Basic</option>
                                            <option value="manager">Manager</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                        <HasError :form="form" field="role" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">Profile Picture</label>
                                        <input id="avatar" type="file" name="avatar" class="form-control">
                                        <HasError :form="form" field="avatar" />
                                    </div>

                                    <button type="submit" class="btn btn-success float-right">
                                        Save changes
                                        <i class="fa fa-user-pen"></i>
                                    </button>

                                </form>
                            </b-tab>

                        </b-tabs>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style>
    .widget-user-header {
        background-position: center center;
        background-size: cover;
    }
</style>

<script>
    export default {
        data() {
            return {
                form: new From({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    role: '',
                    avatar: ''
                })
            }
        },
        created() {
            axios.get("api/profile")
                .then(({
                    data
                }) => (this.form.fill(data)));
            console.log(this.form);
            
        }
    }
</script>
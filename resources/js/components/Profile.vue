<style>
.widget-user-header {
  background-position: center center;
  background-size: cover;
  height: 250px;
}
</style>
<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-3">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background: url('./img/user-cover.jpg') center center; background-size: cover; height: 250px;"
          >
            <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
            <h5 class="widget-user-desc text-right">Web Designer</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="https://via.placeholder.com/50" alt="user Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active" href="#activity" data-toggle="tab">Activity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
                <h2 class>Display User Activity</h2>
              </div>

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input
                        :class="{ 'is-invalid': form.errors.has('name') }"
                        type="name"
                        name="name"
                        class="form-control"
                        id="name"
                        placeholder="Name"
                        v-model="form.name"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input
                        v-model="form.email"
                        type="email"
                        name="email"
                        class="form-control"
                        id="email"
                        placeholder="Email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                    <div class="col-sm-10">
                      <textarea
                        v-model="form.bio"
                        class="form-control"
                        id="bio"
                        name="bio"
                        placeholder="Bio"
                        :class="{ 'is-invalid': form.errors.has('bio') }"
                      ></textarea>
                      <has-error :form="form" field="bio"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                    <div class="col-sm-10">
                      <input
                        type="file"
                        name="photo"
                        id="photo"
                        :class="{ 'is-invalid': form.errors.has('photo') }"
                        @change="updateProfile"
                      />
                      <has-error :form="form" field="photo"></has-error>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password" class="col-sm-6 col-form-label">
                      Password
                      <span>(leave empty if not changing)</span>
                    </label>
                    <div class="col-sm-10">
                      <input
                        v-model="form.password"
                        type="password"
                        name="password"
                        class="form-control"
                        id="password"
                        placeholder="password"
                        :class="{ 'is-invalid': form.errors.has('photo') }"
                      />
                      <has-error :form="form" field="photo"></has-error>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-10">
                      <button
                        type="submit"
                        @click.prevent="updateInfo"
                        class="btn btn-success"
                      >Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: ""
      })
    };
  },
  mounted() {
    console.log("Component mounted");
  },
  methods: {

    updateProfile(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 2111775) {
        reader.onloadend = file => {
          //  console.log('RESULT', reader.result)
          this.form.photo = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        swal.fire("Oops!", "You are uploading alarge file ", "error");
      }
    },

    updateInfo() {
      this.$Progress.start();
      this.form
        .put("api/profile")
        .then(() => {
          toast.fire({
            icon: "success",
            title: "updated successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    }
  },

  created() {
    axios.get("api/profile").then(({ data }) => {
      this.form.fill(data);
    });
  }
};
</script>

<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="pushmenu"
                    href="#"
                    role="button"
                    ><i class="fas fa-bars"></i
                ></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/home" class="nav-link">Home</a>
            </li>
            <!-- <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li> -->
        </ul>

        <ul class="navbar-nav ml-auto px-2">

            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="fullscreen"
                    href="#"
                    role="button"
                >
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="control-sidebar"
                    data-controlsidebar-slide="true"
                    href="#"
                    role="button"
                >
                    <i class="fas fa-th-large"></i>
                </a>
            </li> -->
            <li class="nav-item mt-1">
                <button class="btn btn-sm btn-danger" @click="logout">
                    Logout
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    methods:{
        logout(){
            axios.get('/user-logout')
                .then(function(response) {
                    if(response.data.status == true){
                        window.location.href = '/';
                    }
                });
        }
    }
};
</script>

<style></style>

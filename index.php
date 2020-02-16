<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Consolas disk</title>
<link rel="stylesheet" href="css/style.css">
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body id="body">
    <div class="auth-container" id="auth">
        <div class="auth-body">
            <a v-if="!data.name">Private password: </a><input type="password" v-if="!data.name" placeholder="password here" v-model="password"></input><br>
            <a v-if="data.name">Welcome {{ data.name }}</a>
        </div>
    </div>
    <script>
    new Vue({
    el: "#auth",
    watch: {
        password: function(newPass, oldPass) {
            // todo: add loading icon
            this.debounceLogin();
        },
    },
    created: function() {
        this.debounceLogin = _.debounce(this.login, 750);        
    },
    data: {
        password: '',
        request: {},
        data: {
            name: '',
        },
    },
    methods: {
        login: function() {
            this.request = new URLSearchParams();
            this.request.append('password', this.password);
            console.log("Submit complete!");
            axios
                .post('./login.php',this.request)
                .then(response => this.loadUserData(response))
                .catch(error => console.log(error));
        },
        loadUserData: function(response) {
            this.data = response.data;
            if (this.data.error===undefined) {
                return false;
            }
            localStorage.token = this.data.token;
            localStorage.name = this.data.name;
        },
    },
    mounted() {
        if (localStorage.name & localStorage.token) {
            console.log("You logged in");
        }
    },
    })
    </script>
</body>
</html>


<!--
    <div id="dropzone">
		<form class="box" method="post" action="" enctype="multipart/form-data">
			<div class="container">
            
				$files = scandir("./files");
				for ($i = 2; $i < count($files); $i++) {
					$type = array_pop(explode(".",$files[$i]));
					if (!file_exists ("css/png/".strtoupper ($type).".png")) {
						$type = "file";
					}
					echo '
					<div class="file-block" onClick="window.location=\'files/'.$files[$i].'\'">
						<img class="file-img" src="css/png/'.strtoupper ($type).'.png" height="150px" width="150px"><br>
						<a class="file-name">'.$files[$i].'</a>
					</div>
				';
				}
				
			</div>
		</form>
	</div>
    <script src="download.js"></script>
    -->
<template>
    <div>
        <div class="blog-list">
            <div v-for="post in paginatedPosts" :key="post.id" class="blog-post card mb-3">
                <div class="card-body">
                    <div class="blog-content">
                        <img v-if="post.image" :src="'/images/' + post.image" alt="Blog Image"
                            class="card-img-left img-fluid custom-image" />
                        <div class="blog-text">
                            <h2 class="card-title">{{ post.title }}</h2>
                            <p class="card-text smaller-text">{{ post.content }}</p>
                            <p class="smaller-text">Created By: {{ post.user.name }} </p>
                            <p class="smaller-text">Likes: {{ post.likes_count }} </p>
                            <button class="btn btn-primary mr-2" @click="likePost(post.id)">Like</button>
                            <Modal :postId="post.id" />
                            
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <!-- Pagination controls -->
        <ul class="pagination">
            <li class="page-item" :class="{ active: currentPage === page }" v-for="page in totalPages" :key="page">
                <a class="page-link" @click="changePage(page)">{{ page }}</a>
            </li>
        </ul>
    </div>
</template>
<script>
import { onMounted, ref, computed } from 'vue';
import ApiService from '../services/ApiService';
import Modal from '../components/Modal.vue';
export default {
    components:{
        Modal
    },
    setup() {
        const blogPosts = ref([]);
        const currentPage = ref(1);
        const postsPerPage = 5;

        async function fetchBlogPosts() {
            try {
                const response = await ApiService.get("/api/auth/posts", {});
                console.log(response)
                blogPosts.value = response.data.posts;
            } catch (error) {
                console.error("Failed to fetch blog posts:", error);
            }
        }
        // async function pollForUpdates() {
        //     setInterval(fetchBlogPosts, 30000);
        // }

        async function likePost(postId) {
            try {
                const response = await ApiService.post(`/api/auth/posts/${postId}/like`);
                const liked_by_user = response.data.liked_by_user;
                if (liked_by_user) {
                    alert("You already liked this Post!");
                }
                else {
                    const likedPost = blogPosts.value.find(post => post.id === postId);
                    if (likedPost) {
                        likedPost.likes_count++;
                    }
                }

            } catch (error) {
                console.error("Failed to like the post:", error);
            }
        }
        const paginatedPosts = computed(() => {
            const startIndex = (currentPage.value - 1) * postsPerPage;
            const endIndex = startIndex + postsPerPage;
            return blogPosts.value.slice(startIndex, endIndex);
        });

        const totalPages = computed(() => {
            return Math.ceil(blogPosts.value.length / postsPerPage);
        });

        function changePage(page) {
            currentPage.value = page;
        }
        onMounted(() => {
            fetchBlogPosts();
            // pollForUpdates();
        });
        return {
            blogPosts,
            fetchBlogPosts,
            paginatedPosts,
            totalPages,
            currentPage,
            changePage,
            likePost
        };
    }

}
</script>

<style scoped>
hr {
    border: 2px solid black;
}

.blog-content {
    display: flex;
    align-items: center;
}

.card-img-left {
    max-width: 500px;
    /* Adjust as needed */
    max-height: 300px;
    /* Adjust as needed */
    width: auto;
    height: auto;
    margin-right: 20px;
}

.blog-text {
    flex-grow: 1;
}

.smaller-text {
    font-size: 14px;
    /* Adjust as needed */
}
.button{
	width: 50px;
	height: 50px;
  top:50%;
  position: fixed;
	left: 50%;
	margin-top: -45px;
	margin-left: -50px;
	border-radius: 5px;
	background: none;
	cursor: pointer;
	transition: background 0.5s ease;
}
</style>
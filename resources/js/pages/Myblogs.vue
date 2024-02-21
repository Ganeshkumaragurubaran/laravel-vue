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

export default {
    setup() {
        const blogPosts = ref([]);
        const currentPage = ref(1);
        const postsPerPage = 5;

        async function fetchBlogPosts() {
            try {
                const response = await ApiService.get("/api/auth/my/posts", {});
                console.log(response)
                blogPosts.value = response.data.posts;
            } catch (error) {
                console.error("Failed to fetch blog posts:", error);
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
        });
        return {
            blogPosts,
            fetchBlogPosts,
            paginatedPosts,
            totalPages,
            currentPage,
            changePage,
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
  font-size: 14px; /* Adjust as needed */
}
</style>
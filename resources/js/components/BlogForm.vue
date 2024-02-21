<template>
    <div class="container mt-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Your Blog</h6>
            </div>
            <div class="card-body">
                <form @submit.prevent="addBlogPost" enctype="multipart/form-data">
                    <div class="form-group row ">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label>Title</label>
                            <input type="text" v-model="title" name="title" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="image">Image</label>
                            <input type="file" ref="fileInput" name="image" v-on:change="onFileChange" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="myDateInput" class="form-label text-dark">Content:</label>
                            <textarea rows="2" class="form-control" v-model="content" name="content" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <select v-model="selectedCategory" name="category_id">
                                <option value="" disabled>Select a Category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                    category.name }}</option>
                            </select>
                        </div>
                    </div>
                    {{ selectedCategory }}



                    <div class="text-center col">
                        <button class="btn btn-primary rounded-pill" type="submit">Add</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import Swal from 'sweetalert2'
import { useRouter } from 'vue-router';


export default {
    setup() {
        const router = useRouter();
        const store = useStore();
        const categories = ref([]);
        const title = ref('');
        const content = ref('');
        const image = ref(null);
        const selectedCategory = ref('');

        const fileInput = ref('');

        const fetchCategories = async () => {
            try {
                const response = await fetchCategoriesWithToken();
                categories.value = response.data.category;
                return response.data;
            } catch (error) {
                console.error('Failed to fetch categories:', error);
            }
        };

        const fetchCategoriesWithToken = async () => {
            const token = store.state.token; // Assuming you've stored the user token in the Vuex store
            const headers = {
                Authorization: `Bearer ${token}`,
            };
            return await axios.get('/api/auth/categories', { headers });
        };



        const addBlogPost = async () => {
            const formData = new FormData();
            formData.append('title', title.value);
            formData.append('content', content.value);
            console.log('image value:', image.value);
            formData.append('category_id', selectedCategory.value);
            formData.append('image', image.value);

            const token = store.state.token;
            console.log('FormData:', formData, token);
            const headers = {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'multipart/form-data',
            };

            try {
                const response = await axios.post('/api/auth/blog-posts', formData, { headers });
                Swal.fire({
                    title: "Good job!",
                    text: "You Successfully Created a Blog!",
                    icon: "success"
                });
                router.push({ name: 'myBlogs' })
            } catch (error) {
                console.error('Failed to create a blog post:', error);
            }
        };

        const onFileChange = (e) => {
            console.log("e.target.files", e.target.files[0]);
            image.value = e.target.files[0];
        }
        onMounted(() => {
            fetchCategories(); // Fetch categories when the component is mounted
        });

        return {
            categories,
            selectedCategory,
            // Include other variables and functions as needed
            addBlogPost,
            // setImage,
            content,
            title,
            image,
            fileInput,
            onFileChange,

        };
    },
};
</script>
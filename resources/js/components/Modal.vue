<template>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalScrollable">
        Comment
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Comments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="comments">
                        <h5>Comments</h5>
                        <ul>
                            <li v-for="comment in comments" :key="comment.id">{{ comment.content }}</li>
                        </ul>
                    </div>
                    <div>
                    </div>
                    <form>
                        <div class="form-group">
                            <input class="form-control" id="message-text" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import { onMounted, ref, toRefs } from 'vue'
import apiService from '../services/ApiService';

export default ({
    props: {
        postId: {
            type: Number, // Adjust the type as needed
            required: true,
        },
    },
    setup(props) {

        const comments = ref([]);
        async function fetchComments() {
            try {
                const response = await apiService.get(`/api/auth/comments/${props.postId}`);
                console.log('API Response:', response);
                comments.value = response.data;
            } catch (error) {
                console.error("Failed to fetch comments:", error);
            }
        }

        onMounted(() => {
            fetchComments();
        });
        return {
            comments,
        };
    },

})
</script>

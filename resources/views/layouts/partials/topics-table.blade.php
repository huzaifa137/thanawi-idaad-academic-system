@if (!empty($grouped) && count($grouped))
    @foreach($grouped as $senior => $subjects)
        @foreach($subjects as $subject => $competencies)
            @foreach($competencies as $competency => $topics)
                <div class="table-responsive filter-box mb-5">
                    <h5 class="mb-2 text-primary">
                        {{ $subject }} <small class="text-muted">— {{ $competency }}</small>
                    </h5>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Topic Name</th>
                                <th>Topic Description</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topics as $index => $topic)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $topic->topic_name }}</td>
                                    <td>{{ $topic->topic_description }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary edit-topic-btn" data-id="{{ $topic->id }}"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm btn-danger delete-topic-btn" data-id="{{ $topic->id }}"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endforeach
    @endforeach
@else
    <div class="alert alert-warning">
        No topics available for the selected Senior.
    </div>
@endif

<!-- Edit Topic Modal -->
<div class="modal fade" id="editTopicModal" tabindex="-1" aria-labelledby="editTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editTopicForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editTopicModalLabel">Edit Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="topic_id" id="edit_topic_id">

                    {{-- <div class="mb-3">
                        <label for="edit_competency" class="form-label">Competency</label>
                        <input type="text" class="form-control" id="edit_competency" name="Competency" min="1" required>
                    </div> --}}

                    <div class="mb-3">
                        <label for="edit_topic_name" class="form-label">Topic Name</label>
                        <input type="text" class="form-control" id="edit_topic_name" name="topic_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_topic_description" class="form-label">Topic Description</label>
                        <textarea class="form-control" id="edit_topic_description" name="topic_description" rows="4"
                            required></textarea>
                    </div>

                    <!-- You can add senior/subject/competency if you want to edit those too -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@extends('layouts.admin')
@section('content')

<form action = "{{ url('admin/filterset') }}" method = "post" enctype="multipart/form-data">
{{ csrf_field() }}
    {{-- <div class="container"> --}}


        <div class="card">
            <div class="card-header">
                Add PDF SCAN rule
            </div>

            <div class="card-body">

        <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Mail to</label>
              <input class="form-control" type="text" name="mailto" value="{{$filters[0]->mailto}}"/>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-6 mb-3">
                <label>Do you want to create a PDF from body?</label>
                <div class="form-group">
                    <select class="custom-select" name="pdfFromBody">
                      <option value="0" {{$filters[0]->pdfFromBody ? '' : 'selected'}}>No, only forward existing attachments</option>
                      <option value="1" {{$filters[0]->pdfFromBody ? 'selected' : ''}}>Yes, forward all mail body</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label>Include logos as attachments?</label>
                <div class="form-group">
                    <select class="custom-select" name="logo">
                        <option value="0" {{$filters[0]->logo ? '' : 'selected'}}>No</option>
                        <option value="1" {{$filters[0]->logo ? 'selected' : ''}}>Yes</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label>Include profile photos as attachments?</label>
                <div class="form-group">
                    <select class="custom-select" name="profile">
                        <option value="0" {{$filters[0]->profile ? '' : 'selected'}}>No</option>
                        <option value="1" {{$filters[0]->profile ? 'selected' : ''}}>Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label>Create PDF if email body is empty?</label>
                <div class="form-group">
                    <select class="custom-select" name="allowEmptyContent">
                        <option value="0" {{$filters[0]->allowEmptyContent ? '' : 'selected'}}>No</option>
                        <option value="1" {{$filters[0]->allowEmptyContent ? 'selected' : ''}}>Yes</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label>Merge multiple attachments (jpeg) into one PDF?</label>
                <div class="form-group">
                    <select class="custom-select" name="multipleJpgIntoPdf">
                        <option value="0" {{$filters[0]->multipleJpgIntoPdf ? '' : 'selected'}}>No</option>
                        <option value="1" {{$filters[0]->multipleJpgIntoPdf ? 'selected' : ''}}>Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label>What to do with fiels pasted into body that arent images?
                    (e.g a.doc file palced in body, instead of attachment)</label>
                <div class="form-group">
                    <select class="custom-select">
                      <option value="">Download and foward as attachment</option>
                      <option value="1">1</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label>Split one mail into multiple mails if size is</label>

                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <select class="custom-select">
                            <option value="0">Bigger</option>
                            <option value="1">Smaller</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="validationDefault03" placeholder="5">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="custom-select">
                                <option value="0">MB(Megabyte)</option>
                                <option value="1">KB(Kilobyte)</option>
                                <option value="2">B(Byte)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select class="custom-select">
                        <option value="true">Yes</option>
                        <option value="false">No</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>

        <div class="form-group row">
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck1">
                    <label class="form-check-label">
                    Consider following extensions in body as non existent:
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck1">
                    <label class="form-check-label">
                        Only if include workd:
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sizeLimit" id="gridCheck1">
                    <label class="form-check-label">
                        Only if size is:
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {{-- <label class="form-check-label">
                        Between
                    </label> --}}
                <select class="custom-select">
                    <option value="0">Between</option>
                    {{-- <option value="1">Bigger than</option>
                    <option value="2">Smaller than</option> --}}
                </select>
                </div>
            </div>
            <div class="col-md-1">
                <input class="form-control" type="number" name="minSize" value='0' min="0"/>
            </div>
            <label>&mdash;</label>
            <div class="col-md-1">
                <input class="form-control" type="number" name="maxSize" value='700'/>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="custom-select" name="sizeUnit">
                        <option value="0" {{$filters[0]->sizeUnit == 0 ? 'selected' : ''}}>MB(Megabyte)</option>
                        <option value="1" {{$filters[0]->sizeUnit == 1 ? 'selected' : ''}}>KB(Kilobyte)</option>
                        <option value="2" {{$filters[0]->sizeUnit == 2 ? 'selected' : ''}}>B(Byte)</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label>Who should the rule apply to?</label>
                <label>Our mail reciever (internal user)</label>
                <div class="form-group">
                    <select class="custom-select">
                      <option value="">Global</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label>Who should the rule apply to?</label>
                <label>Our mail sender (internal user)</label>
                <div class="form-group">
                    <select class="custom-select">
                      <option value="">Global</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label>Who should the rule apply to?</label>
                <label>The mail sender (external user)</label>
                <div class="form-group">
                    <select class="custom-select">
                      <option value="">Global</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- <div class="float-right"> --}}
        <div class="form-group">
            <button class="btn btn-primary" type="submit" style="width: 80px; margin-right: 10px;">OK</button>
            <button class="btn btn-outline-primary" type="submit" style="width: 80px;">Cancel</button>
        </div>
        {{-- </div> --}}

        {{-- <div class="form-group">
            <input class="form-control" type="text" name="mailto" value="{{$filters[0]->mailto}}"/>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="terms" {{$filters[0]->filter1 ? 'checked' : '' }} />
            <label>Don't Forward Empty Mail</label>
        </div>
        <div class="form-group">
            <button class="btn btn-success" type="submit">Submit</button>
        </div> --}}
            </div>
    </div>
</form>
@endsection


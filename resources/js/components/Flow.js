import React from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

class Flow extends React.Component {
    constructor(props) {
        super(props);
        this.handleNewType = this.handleNewType.bind(this);
        this.handleTextChange = this.handleTextChange.bind(this);
        this.handleFlowSubmit = this.handleFlowSubmit.bind(this);
        this.flowForm = React.createRef();
        this.state = {
            id: '',
            flowArr: [],
            newType: '',
        };
    }

    handleNewType(newType) {

        switch (newType) {
            case 'paragraph':
                this.setState((state) => state.flowArr.push({type: 'paragraph', value: ''}));
                break;
            case 'one':
                this.setState((state) => state.flowArr.push({type: 'one', value1: ''}));
                break;
            case 'two':
                // NOTE: COPY THE NEW ARRAY BELOW TO THE REST
                this.setState((state) => state.flowArr.push({type: 'two', value1: ''}));
                break;
            case 'four':
                this.setState((state) => state.flowArr.push({type: 'four', value1: ''}));
                break;
            case 'video':
                this.setState((state) => state.flowArr.push({type: 'video', value1: ''}));
                break;
        }
    }

    handleTextChange(index, e) {
        let stateArr = this.state.flowArr.slice(); // sliced to protect against state mutations
        stateArr[index].value = e.target.value;
        this.setState({flowarr: stateArr});
    }

    componentDidMount() {
        // grab the current project flow data passed in through the hidden input
        let flowData = JSON.parse(document.getElementById('flow-data').value);
        this.setState({flowArr: flowData});

        // get the project ID
        let projectId = document.getElementById('project-id').value;
        this.setState({id: projectId});
    }

    handleFlowSubmit(e) {
        
        event.preventDefault();
        
        // initiate a form object then get the files in the form flowForm since these are uncontrolled components using the normal DOM and not react components
        let formObject = new FormData(flowForm);

        // this is needed so that Laravel correctly parses the form data obj sent through PUT method
        formObject.append('_method', 'PUT');

        // add the flow array but needs to be stringified for use with FormData object
        formObject.append('flowArr', JSON.stringify(this.state.flowArr));
        
        Axios.post('/projects/' + this.state.id, formObject)
            .then(res => {console.log(res)})
            .catch(err => {console.log(err)})
        
    }
    render() {

        // create an array of element components
        let flowInputs = this.state.flowArr.map((item, index) => {

            if (item.type == 'paragraph') {
                return <textarea className="form-control my-3" value={item.value} key={index} onChange={(e) => this.handleTextChange(index, e)}></textarea>;

            } else if (item.type == 'video') {
                return <textarea className="form-control my-3" value={this.state.flowArr[index].video} key={index} onChange={(e) => this.handleTextChange(index, e)}></textarea>;

            } else if (item.type == 'one') {
                if (item.value1 == '') {
                    return <input type="file" className="my-2" key={index} name={'file_' + index.toString() + "_1"}/>;
                } else {
                    return (
                        // if the item has already been uploaded, show the photo instead of browse
                        <div class="row justify-content-center my-3" key={index}>
                            <img src={this.state.flowArr[index].value1} />
                        </div>
                    );
                }

            } else if (item.type == 'two') {
                if (item.value1 == '') {
                    // Below, dynamic refs are set using string literal template
                    return (
                        <div className="my-3" key={index}>
                            <input type="file" name={'file_' + index.toString() + "_1"}></input>
                            <input type="file" name={'file_' + index.toString() + "_2"}></input>
                        </div>
                    );
                } else {

                return (
                    // if already uploaded, show the files instead of inputs
                    <div className="row justify-content-center my-3" key={index}>
                        <div className="col-md-6">
                            <img src={this.state.flowArr[index].value1} />
                        </div>
                        <div className="col-md-6">
                            <img src={this.state.flowArr[index].value2} />
                        </div>
                    </div>
                );
                }

            } else if (item.type == 'four') {
                if (item.value1 == '') {
                    return (
                        <div key={index}>
                            <input type="file" name={'file_' + index.toString() + "_1"}></input>
                            <input type="file" name={'file_' + index.toString() + "_2"}></input>
                            <input type="file" name={'file_' + index.toString() + "_3"}></input>
                            <input type="file" name={'file_' + index.toString() + "_4"}></input>
                        </div>
                    );
                } else {
                    return (
                        // if already uploaded, show the files instead of inputs
                        <div key={index}>
                            <div className="row justify-content-center my-3">
                                <div className="col-md-6">
                                    <img src={this.state.flowArr[index].value1} />
                                </div>
                                <div className="col-md-6">
                                    <img src={this.state.flowArr[index].value2} />
                                </div>
                            </div>
                            <div className="row justify-content-center mb-3">
                                <div className="col-md-6">
                                    <img src={this.state.flowArr[index].value3} />
                                </div>
                                <div className="col-md-6">
                                    <img src={this.state.flowArr[index].value4} />
                                </div>
                            </div>
                        </div>
                    );
                }
            }
        })

        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        { flowInputs }
                        <div className="dropdown text-center">
                            <button className="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add New Item
                            </button>
                            <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div className="dropdown-item" onClick={() => this.handleNewType('paragraph')}>Paragraph</div>
                                <div className="dropdown-item" onClick={() => this.handleNewType('one')}>Single Photo</div>
                                <div className="dropdown-item" onClick={() => this.handleNewType('two')}>Two Photo Group</div>
                                <div className="dropdown-item" onClick={() => this.handleNewType('four')}>Four Photo Group</div>
                                <div className="dropdown-item" onClick={() => this.handleNewType('video')}>Single Video</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row justify-content-center">
                    <button onClick={this.handleFlowSubmit} className="btn btn-primary text-center mt-3">Save Changes to Flow</button>
                </div>
            </div>
        );
    }
}

export default Flow;

if (document.getElementById('flow')) {
    ReactDOM.render(<Flow />, document.getElementById('flow'));
}

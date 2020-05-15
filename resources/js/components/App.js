import React, {Component} from 'react';
import axios from 'axios';

class App extends Component {
    constructor(props) {
        super(props);

        this.state = {
            body: "",
            posts: [],
            loading: false
        }

        //bind
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.getPosts = this.getPosts.bind(this);
        this.renderPosts = this.renderPosts.bind(this);
    }

    handleSubmit(e) {
        //Prevents page reload
        e.preventDefault();
        
        //Perform a post request on the host/posts url
        axios.post('/posts', {
            body: this.state.body
        }).then(response => {
            //Save the new post in the state
            this.setState({
                posts: [response.data, ...this.state.posts]
            })
        });
        //Clear the textarea
        this.setState({
            body: ""
        });
    }

    getPosts() {
        //this.setState({loading: true});
        axios.get('/posts').then(response => {
            this.setState({
                posts: [...response.data.posts],
                //loading: false
            });
        });
    }

    UNSAFE_componentWillMount() {
        this.getPosts();
    }

    componentDidMount() {
        //Listen the PostCreated event from the backend
        window.Echo.private('new-post').listen('.new-following-post', (e) => {
            console.log(e);
            //Check if the poster id correspond to a following user
            if (window.Laravel.user.following.includes(e.post.user_id)) {
                this.setState({
                    posts: [e.post, ...this.state.posts]
                });
            }
        });
        //this.interval = setInterval(() =>this.getPosts(), 10000);
    }

    componentWillUnmount() {
        //clearInterval(this.interval);
    }

    handleChange(e) {
        this.setState({
            body:e.target.value
        });
    }

    renderPosts() {
        return this.state.posts.map(post => (
            <div key={post.id} className="media">
                <div className="media-left">
                    <img
                        src={post.user.avatar}
                        className="media-object mr-2"
                    ></img>
                </div>
                <div className="media-body">
                    <div className="user">
                        <a href={`/users/${post.user.username}`}>
                            {post.user.username}
                        </a> - {post.humanCreatedAt}
                    </div>
                    <p>{post.body}</p>
                </div>
            </div>
        ));
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">
                                Tweet something...
                            </div>

                            <div className="card-body">
                                <form onSubmit={this.handleSubmit}>
                                    <div className="form-group">
                                        <textarea
                                            value={this.state.body}
                                            onChange={this.handleChange}
                                            className="form-control"
                                            rows="5"
                                            maxLength="140"
                                            placeholder="Whats up?"
                                            required
                                        />
                                    </div>
                                    <input
                                        type="submit"
                                        value="Post"
                                        className="form-control"
                                    />
                                </form>
                            </div>
                        </div>
                    </div>

                    <div className="col-md-6">
                        <div className="card">
                            <div className="card-header">Recent Tweets</div>
                            <div className="card-body">
                                {this.state.loading ? 'Loading...' : this.renderPosts()}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default App;
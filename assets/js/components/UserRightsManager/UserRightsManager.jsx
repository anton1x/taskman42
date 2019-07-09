import React from 'react';
import $ from 'jquery';
import 'bootstrap';
import ListItem from "./ListItem";
import Header from "./Header";
import GroupListItem from './GroupListItem';


class UserRightsManager extends React.Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            data: {
                hierarchy: [],
                users: []
            },
            selectedItems: []
        };

        this.handleListItemClick = this.handleListItemClick.bind(this);
        this.handleListItemChange = this.handleListItemChange.bind(this);
        this.handleGroupItemChange = this.handleGroupItemChange.bind(this);
    }

    mapDataToState(data)
    {
        this.setState({
            data: {
                hierarchy: data.hierarchy,
                users: data.users
            }
        })
    }

    componentDidMount()
    {

        $.ajax({
            url: this.props.endpoint,
            type: 'get',
        }).then(
            (data)=>this.mapDataToState(data)
        );


    }

    handleListItemChange(user_id, rights)
    {

        if(user_id == -1)
            return false;

        this.setState((state) => {
            state.data.users[user_id].rights = rights;
            return state;
        });

    }

    handleListItemClick(user_id)
    {
        this.toggleSelected(user_id);
    }

    handleGroupItemChange(rights)
    {
        this.setState((state) => {

            $.each(state.selectedItems, (key, id)=>{
                if(state.data.users[id].rights !== rights){

                    state.data.users[id].rights = rights;
                    console.log(1,state.data.users[id].rights);

                    state.data.users[id].rights = [...rights];
                    console.log(2,state.data.users[id].rights);
                }
            });

           return state;
        });
    }

    isSelected(user_id)
    {
        return this.state.selectedItems.indexOf(user_id) >= 0;
    }

    addSelected(user_id)
    {
        this.setState((state) => {
            return {selectedItems: [...state.selectedItems, user_id]}
        })
    }

    removeSelected(user_id)
    {
        if(this.isSelected(user_id))
        {
            this.setState((state) => {
                state.selectedItems.splice(
                    state.selectedItems.indexOf(user_id),
                    1
                );

                return state;
            });
        }
    }

    toggleSelected(user_id)
    {
        if(!this.isSelected(user_id)){
            this.addSelected(user_id);
        }
        else{
            this.removeSelected(user_id);
        }


    }

    hasSelectedItems()
    {
        return this.state.selectedItems.length > 0;
    }

    getUserById(id) {
        return this.state.data.users[id];
    }

    render(){

        //const users = this.state.data.users;
        return <div>
            <table className="col-12">
                <Header hierarchy={this.state.data.hierarchy} />
                <tbody>
                    {this.hasSelectedItems() &&
                        <GroupListItem
                            className="table-danger"
                            hierarchy={this.state.data.hierarchy}
                            onGroupItemChange={this.handleGroupItemChange}
                        >
                            С выбранными
                        </GroupListItem>
                    }
                    {Object.keys(this.state.data.users).map((key)=>
                        <ListItem
                            selected={this.isSelected(this.state.data.users[key].id)}
                            key={key}
                            onChange={this.handleListItemChange}
                            onUserClick={this.handleListItemClick}
                            hierarchy={this.state.data.hierarchy}
                            user={this.state.data.users[key]}
                        >
                            {this.state.data.users[key].name}
                        </ListItem>
                    )}
                </tbody>

            </table>
          </div>;
    }
}

export default UserRightsManager;
Ext.application({
    name: 'MyApp',
    launch: function() {
        Ext.define('User', {
            extend: 'Ext.data.Model',
            fields: ['id', 'name', 'education']
        });
        var userStore = Ext.create('Ext.data.Store', {
            model: 'User',
            autoSync: true,
            proxy: {
                // load using HTTP
                type: 'ajax',
                url: '/app_dev.php/ajaxgetdata',
                reader: {
                    type: 'json'
//                    model: 'User'
                },
                writer: {
                    type: 'json'
                }

            }

        });
        userStore.load();
        var Editing = Ext.create('Ext.grid.plugin.RowEditing');
        Ext.create('Ext.grid.Panel', {
            plugins: [Editing],
            renderTo: Ext.getBody(),
            store: userStore,
            width: 400,
            height: 200,
            title: 'Application Users',
            columns: {
                defaults: {
                    editor: 'textfield'
                },
                items: [
                    {
                        text: 'Id',
                        width: 100,
                        dataIndex: 'id'
                    },
                    {
                        text: 'Name',
                        width: 100,
                        dataIndex: 'name'//,
                                //hidden: true
                    },
                    {
                        text: 'Education',
                        width: 100,
                        dataIndex: 'education'
                    }
                ]

            }
        });
    }
});
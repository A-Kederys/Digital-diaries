using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace almanR
{
    public partial class formUserInfo : Form
    {
        formUser form;
        public formUserInfo()
        {
            InitializeComponent();
            form = new formUser(this);
        }


        public void Display()
        {

            DBuser.displayAndSearch("SELECT blogger_id, blogger_name, blogger_fname, blogger_email, admin FROM users", dataGridView1);
        }
        private void btnEdit_Click(object sender, EventArgs e)
        {
            form.Clear();
            form.ShowDialog();
        }

        private void formUserInfo_Shown(object sender, EventArgs e)
        {
            Display();
        }

        private void txtSearch_TextChanged(object sender, EventArgs e)
        {
            DBuser.displayAndSearch("SELECT blogger_id, blogger_name, blogger_fname, blogger_email, admin FROM users WHERE blogger_name LIKE'%" + txtSearch.Text + "%'", dataGridView1);
        }

        private void dataGridView1_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            //editing
            if(e.ColumnIndex == 0)
            {
                form.Clear();
                form.id = dataGridView1.Rows[e.RowIndex].Cells[1].Value.ToString();
                form.fname = dataGridView1.Rows[e.RowIndex].Cells[2].Value.ToString();
                form.lname = dataGridView1.Rows[e.RowIndex].Cells[3].Value.ToString();
                form.email = dataGridView1.Rows[e.RowIndex].Cells[4].Value.ToString();
                form.admin = dataGridView1.Rows[e.RowIndex].Cells[5].Value.ToString();
                if(form.admin == "True")
                {
                    form.admin = "Admin";
                }
                if(form.admin == "False")
                {
                    form.admin = "User";
                }
                form.updateInfo();
                form.ShowDialog();
                return;

            }

        }

        private void formUserInfo_Load(object sender, EventArgs e)
        {
            string sql = "datasource=localhost;port=3306;username=root;password=;database=kursinis_heterogenine";
            //posts
            MySqlConnection con = new MySqlConnection(sql);
            try
            {
                con.Open();
                string query1 = "SELECT COUNT(post_id) FROM posts";
                MySqlCommand cmd = new MySqlCommand(query1, con);
                MySqlDataReader dr = cmd.ExecuteReader();
                while (dr.Read())
                {
                    labelPosts.Text = dr.GetValue(0).ToString();
                }
            }
            catch (MySqlException ex)
            {

                MessageBox.Show("MySQL Connection! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            con.Close();

            //categories
            MySqlConnection con2 = new MySqlConnection(sql);
            try
            {
                con2.Open();
                string query2 = "SELECT COUNT(cat_id) FROM categories";
                MySqlCommand cmd = new MySqlCommand(query2, con2);
                MySqlDataReader dr = cmd.ExecuteReader();
                while (dr.Read())
                {
                    labelCategories.Text = dr.GetValue(0).ToString();
                }
            }
            catch (MySqlException ex)
            {

                MessageBox.Show("MySQL Connection! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            con2.Close();

            //users
            MySqlConnection con3 = new MySqlConnection(sql);
            try
            {
                con3.Open();
                string query3 = "SELECT COUNT(blogger_id) FROM users";
                MySqlCommand cmd = new MySqlCommand(query3, con3);
                MySqlDataReader dr = cmd.ExecuteReader();
                while (dr.Read())
                {
                    labelUsers.Text = dr.GetValue(0).ToString();
                }
            }
            catch (MySqlException ex)
            {

                MessageBox.Show("MySQL Connection! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            con3.Close();

            //popular
            MySqlConnection con4 = new MySqlConnection(sql);
            try
            {
               con4.Open();
               string query4 = "SELECT categories.cat_name, COUNT(*) as cat_count " +
                    "FROM posts " +
                    "INNER JOIN categories ON categories.cat_id = posts.cat_id " +
                    "GROUP BY posts.cat_id " +
                    "ORDER BY cat_count DESC " +
                    "LIMIT 1";
                MySqlCommand cmd = new MySqlCommand(query4, con4);
                MySqlDataReader dr = cmd.ExecuteReader();
                while (dr.Read())
                {
                    labelPopularName.Text = dr.GetValue(0).ToString();
                    labelPopularCount.Text = dr.GetValue(1).ToString();
                }
            }
            catch (MySqlException ex)
            {

                MessageBox.Show("MySQL Connection! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            con4.Close();
        }
    }
}

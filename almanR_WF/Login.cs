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
    public partial class Login : Form
    {
        public Login()
        {
            InitializeComponent();
        }

        private void lblExit_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }

        private void btnLogin_Click(object sender, EventArgs e)
        {
            string cs = "datasource=localhost;port=3306;username=root;password=;database=kursinis_heterogenine";
            var con = new MySqlConnection(cs);

            try
            {
                con.Open();
                string stm = "SELECT mod_username, mod_pass FROM moderator WHERE mod_username=@Username AND mod_pass=@Password";
                var cmd = new MySqlCommand(stm, con);

                cmd.Parameters.AddWithValue("@Username", txtUsername.Text);
                cmd.Parameters.AddWithValue("@Password", txtPassword.Text);
                if (txtUsername.Text == "")
                {
                    MessageBox.Show("You forgot to put your username!", "Error:", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    return;
                }
                else if (txtPassword.Text == "")
                {
                    MessageBox.Show("You forgot to put your username!", "Error:", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    return;
                }
                cmd.ExecuteNonQuery();
                main_form();

            }
            catch (MySqlException ex)
            {

                MessageBox.Show("Login Failed! \n" + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            con.Close();
        }

        private void main_form()
        {
            this.Hide();
            formUserInfo frm = new formUserInfo();
            frm.ShowDialog();
            this.Close();   

        }
    }
}
